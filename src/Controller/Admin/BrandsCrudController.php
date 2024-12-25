<?php

namespace App\Controller\Admin;

use App\Entity\Brands;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class BrandsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Brands::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Fournisseur')
            ->setEntityLabelInPlural('Fournisseurs')
            ->setSearchFields(['id', 'name']);
    }

    public function configureFields(string $pageName): iterable
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        $fields = [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name', "nom de la marque")
                ->onlyOnForms()
                ->setSortable(true),
            UrlField::new('name', "nom de la marque")
                ->addCssClass("font-bold")
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
            AssociationField::new('categories', "Catégories")
                    ->formatValue(function ($value, $entity) {
                        return implode(', ', $entity->getCategories()->map(function($category) {
                            return $category->getName();
                            })->toArray());
                        })
                ->setSortable(true)
                ->setFormTypeOptions([
                    'choice_label' => 'name',
                    'multiple' => true,
                ]),
            IntegerField::new('familiesCount', "nombre de Familles")
                ->setTextAlign("center")
                ->onlyOnIndex(),
            IntegerField::new('linksCount', "nombre de liens")
                ->setTextAlign("center")
                ->setSortable(false)
                ->onlyOnIndex(),
        ];

        if ($pageName === Crud::PAGE_DETAIL) {
            $fields = [
                IdField::new('id'),
                TextField::new('name', "nom de la marque"),
                AssociationField::new('categories', "Catégories"),
                DateField::new('createdAt', "Crée le"),
                DateField::new('updatedAt', "Modifié le"),
                IntegerField::new('familiesCount', "nombre de Familles"),
                IntegerField::new('linksCount', "nombre de liens"),
            ];
        }

        return $fields;
    }
}
