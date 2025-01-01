<?php

namespace App\Controller\Admin;

use App\Entity\Brands;
use App\Form\LinkType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BrandsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Brands::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $brand = new Brands();
        $brand->setCreatedAt(new DateTimeImmutable());
        $brand->setUpdatedAt(new DateTimeImmutable());
        $brand->setSlug('Default');
        return $brand;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $slugger = new AsciiSlugger();
        $entityInstance->setSlug(strtolower($slugger->slug($entityInstance->getName())));
        $entityInstance->setUpdatedAt(new DateTimeImmutable());
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $slugger = new AsciiSlugger();
        $entityInstance->setSlug(strtolower($slugger->slug($entityInstance->getName())));
        $entityInstance->setUpdatedAt(new DateTimeImmutable());
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Fournisseur')
            ->setEntityLabelInPlural('Fournisseurs')
            ->setSearchFields(['id', 'name'])
            ->setPageTitle(Crud::PAGE_DETAIL, function (Brands $category) {
                return sprintf('%s <small>(#%d)</small>',
                     $category->getName(), $category->getId());
            });
    }

    public function configureFields(string $pageName): iterable
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        $fields = [];

        if ($pageName === Crud::PAGE_INDEX){
            $fields = [
                IdField::new('id', "ID"),
                UrlField::new('name', "nom de la marque")
                    ->formatValue(function ($value, $entity) use ($adminUrlGenerator) {
                        $url = $adminUrlGenerator
                            ->setController(self::class)
                            ->setAction(Action::DETAIL)
                            ->setEntityId($entity->getId())
                            ->generateUrl();
                        return sprintf('<a href="%s">%s</a>', $url, $value);
                    })
                    ->setSortable(true),
                AssociationField::new('categories', "Catégories")
                    ->formatValue(function ($value, $entity) {
                        return implode(', ', $entity->getCategories()->map(function($category) {
                            return $category->getName();
                        })->toArray());
                    })
                    ->setSortable(true),
                IntegerField::new('familiesCount', "nombre de Familles")
                    ->setTextAlign("center"),
                AssociationField::new('links', "Liens")
                    ->setTemplatePath('admin/fields/linksTable.html.twig'),
                    
            ];
        }

        if($pageName === Crud::PAGE_NEW || $pageName === Crud::PAGE_EDIT){
            $fields = [
                TextField::new('name', "nom de la marque"),
                AssociationField::new('categories', "Catégories")
                    ->setFormTypeOptions([
                        'choice_label' => 'name',
                        'multiple' => true,
                    ]),
                TextField::new('File')
                    ->setFormType(VichImageType::class)
                    ->setRequired(false),
                CollectionField::new('links', "Liens")
                    ->setEntryType(LinkType::class)
                    ->allowAdd(true)
                    ->allowDelete(true)
                    ->setFormTypeOptions([
                        'by_reference' => false,
                    ]),
            ];
        }

        if($pageName === Crud::PAGE_DETAIL){
            $fields = [
                IdField::new('id', "ID"),
                TextField::new('name', "nom de la marque"),
                AssociationField::new('categories', "Catégories")
                    ->formatValue(function ($value, $entity) {
                        return implode(', ', $entity->getCategories()->map(function($category) {
                            return $category->getName();
                        })->toArray());
                    }),
                DateField::new('_createdAt', "Crée le"),
                DateField::new('_updatedAt', "Modifié le"),
                IntegerField::new('familiesCount', "nombre de Familles"),
                AssociationField::new('links', "Liens")
                    ->setTemplatePath('admin/fields/linksTable.html.twig'),
                ImageField::new('thumbail', "Logo de la marque")
                    ->setBasePath('/images/brands')
                    ->setRequired(false),
            ];
        }

        return $fields;
    }
}
