<?php

namespace App\Controller\Admin;

use App\Entity\FamilyCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\String\Slugger\AsciiSlugger;

class FamilyCategoryCrudController extends AbstractCrudController
{

    public function __construct(
        private AsciiSlugger $slugger
    ){}
    
    public static function getEntityFqcn(): string
    {
        return FamilyCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Family Category')
            ->setEntityLabelInPlural('Family Categories')
            ->setSearchFields(['id', 'name', 'parents']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('name', 'Title'),
            DateTimeField::new('_updatedAt', 'Updated At')
                ->hideOnForm(),
            AssociationField::new('parents', 'Parent Category')
                ->setFormTypeOption("choice_label","name")
                ->setFormTypeOption( "required",false)  
                ->setTemplatePath('admin/fields/parents.html.twig')
                ->setSortable(true),
        ];
    }
}
