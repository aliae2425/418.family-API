<?php

namespace App\Controller\Admin;

use App\Entity\BrandCategory;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BrandCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BrandCategory::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $brandCategory = new BrandCategory();
        $brandCategory->setCreatedAt(new DateTimeImmutable());
        $brandCategory->setUpdatedAt(new DateTimeImmutable());
        return $brandCategory;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setUpdatedAt(new DateTimeImmutable());
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setUpdatedAt(new DateTimeImmutable());
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Categorie')
            ->setEntityLabelInPlural('Categories de fabricants')
            ->setSearchFields(['id', 'name']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new("name",'title'),
            DateTimeField::new('_updatedAt', "last update")
                ->hideOnForm(),
        ];
    }


}
