<?php

namespace App\Controller\Admin;

use App\Entity\FamilyCategory;
use Doctrine\ORM\EntityManagerInterface;
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
            ->setEntityLabelInSingular('Section')
            ->setEntityLabelInPlural('Arboresence')
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
