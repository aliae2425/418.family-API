<?php

namespace App\Controller\Admin;

use App\Entity\Family;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Validator\Constraints\Date;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FamilyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Family::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $family = new Family();
        $family->setCreatedAt(new \DateTimeImmutable());
        $family->setUpdatedAt(new \DateTimeImmutable());
        return $family;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setUpdatedAt(new \DateTimeImmutable());
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setUpdatedAt(new \DateTimeImmutable());
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Famille')
            ->setEntityLabelInPlural('Familles')
            ->setSearchFields(['id', 'name', 'updatedAt'])
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {

        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        $fields = [];

        if ($pageName == Crud::PAGE_INDEX){
            $fields = [
                IdField::new('id', 'ID'),
                UrlField::new('name', "nom de la famille")
                    ->formatValue(function ($value, $entity) use ($adminUrlGenerator) {
                        $url = $adminUrlGenerator
                            ->setController(self::class)
                            ->setAction(Action::DETAIL)
                            ->setEntityId($entity->getId())
                            ->generateUrl();
                        return sprintf('<a href="%s">%s</a>', $url, $value);
                    })
                    ->setSortable(true),
                DateTimeField::new('createdAt', 'Créé le'),
                DateTimeField::new('updatedAt', 'Mis à jour'),
                TextField::new('revitFamily'),
            ];
        }

        if ($pageName == Crud::PAGE_NEW || $pageName == Crud::PAGE_EDIT){
            $fields = [
                TextField::new('name', 'Nom de la famille'),
                TextField::new('revitFamilyFile', 'Fichier Revit')
                    ->setFormType(VichImageType::class)
                    ->setRequired(true),
                TextField::new('thumbnailFile', 'Preview')
                    ->setFormType(VichImageType::class)
                    ->setRequired(false),
                AssociationField::new('familyCategory', 'Catégorie')
                    ->setRequired(true)
                    ->setFormTypeOptions([
                        'choice_label' => 'name',
                    ]),
                AssociationField::new('brand', 'Marque')
                    ->setRequired(false)
                    ->setFormTypeOptions([
                        'choice_label' => 'name',
                    ]),

            ];
        }

        if ($pageName == Crud::PAGE_DETAIL){
            $fields = [
                IdField::new('id', 'ID'),
                TextField::new('name', 'Nom de la famille'),
                DateTimeField::new('createdAt', 'Créé le'),
                DateTimeField::new('updatedAt', 'Mis à jour'),
           ];
        }

        return $fields;
    }

}
