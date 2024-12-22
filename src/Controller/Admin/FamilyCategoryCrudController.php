<?php

namespace App\Controller\Admin;

use App\Entity\FamilyCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FamilyCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FamilyCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name', 'Title')
                ->addCssClass('font-weight-bold'),
            DateTimeField::new('_updatedAt', 'Updated At'),
            AssociationField::new('parents', 'Parent Category')
                ->setTemplatePath('admin/fields/parents.html.twig')
                ->setSortable(true),
        ];
    }
}
