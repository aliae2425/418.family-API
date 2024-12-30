<?php

namespace App\Controller\Admin;

use App\Entity\FamilyCategory;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\String\Slugger\AsciiSlugger;

class FamilyCategoryCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return FamilyCategory::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $familyCategory = new FamilyCategory();
        $familyCategory->setCreatedAt(new \DateTimeImmutable());
        $familyCategory->setUpdatedAt(new \DateTimeImmutable());
        $familyCategory->setSlug("default-slug");
        return $familyCategory;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $slugger = new AsciiSlugger();
        $entityInstance->setSlug($slugger->slug($entityInstance->getName()));
        $entityInstance->setUpdatedAt(new \DateTimeImmutable());
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $slugger = new AsciiSlugger();
        $entityInstance->setSlug(strtolower($slugger->slug($entityInstance->getName())));
        $entityInstance->setUpdatedAt(new \DateTimeImmutable());
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Categorie de Famille')
            ->setEntityLabelInPlural('Categories de Familles')
            ->setSearchFields(['id', 'name'])
            ->setPageTitle(Crud::PAGE_DETAIL, function (FamilyCategory $category) {
                return sprintf('Details de la Categorie: %s <small>(#%d)</small>',
                     $category->getName(), $category->getId());
            });
    }

    public function configureFields(string $pageName): iterable
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        $fields = [];

        if ($pageName === Crud::PAGE_INDEX) {
            $fields = [
                IdField::new('id')->onlyOnIndex(),
                UrlField::new('name', "Titre")
                    ->formatValue(function ($value, $entity) use ($adminUrlGenerator) {
                        $url = $adminUrlGenerator
                            ->setController(self::class)
                            ->setAction(Action::DETAIL)
                            ->setEntityId($entity->getId())
                            ->generateUrl();
                        return sprintf('<a href="%s">%s</a>', $url, $value);
                    })
                    ->onlyOnIndex()
                    ->setSortable(true),
                AssociationField::new('parents', 'Parent Category')
                    ->setFormTypeOption("choice_label", "name")
                    ->setFormTypeOption("required", false),
                IntegerField::new('childCount', "Nombre d'Enfants")
                    ->setTextAlign("center")
                    ->onlyOnIndex(),
                IntegerField::new('familyCount', "Nombre de Familles")
                    ->setTextAlign("center")
                    ->onlyOnIndex(),
                DateTimeField::new('_updatedAt', 'Dernière Mise à Jour')
                    ->onlyOnIndex(),
            ];
        }

        if ($pageName === Crud::PAGE_NEW || $pageName === Crud::PAGE_EDIT) {
            $fields = [
                TextField::new('name', 'Titre'),
                AssociationField::new('parents', 'Parent Category')
                    ->setFormTypeOption("choice_label", "name")
                    ->setFormTypeOption("required", false),
            ];
        }

        if ($pageName === Crud::PAGE_DETAIL) {
            $fields = [
                IdField::new('id'),
                TextField::new('name', 'Titre'),
                AssociationField::new('parents', 'Parent Category')
                    ->setFormTypeOption("choice_label", "name"),
                AssociationField::new('child', 'Arborescence Enfant')
                    ->setTemplatePath('admin/fields/categoryChild.html.twig'),
                AssociationField::new('families', 'Familles Associées')
                    ->setTemplatePath('admin/fields/familiesTable.html.twig')
                    ->onlyOnDetail(),
            ];
        }   

        return $fields;
    }
}
