<?php

namespace App\Controller\Admin;

use App\Entity\BrandCategory;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Faker\Core\File;
use PharIo\Manifest\Url;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Vich\UploaderBundle\Form\Type\VichImageType;

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
            ->setSearchFields(['id', 'name'])
            ->setPageTitle(Crud::PAGE_DETAIL, function (BrandCategory $category) {
                return sprintf('Details de : %s <small>(#%d)</small>', $category->getName(), $category->getId());
            });;
    }


    public function configureFields(string $pageName): iterable
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        
        $fields = [];

        if ($pageName === Crud::PAGE_INDEX){
            $fields = [
                IdField::new('id'),
                UrlField::new('name', "Titre")
                    ->formatValue(function ($value, $entity) use ($adminUrlGenerator) {
                        $url = $adminUrlGenerator
                            ->setController(self::class)
                            ->setAction(Action::DETAIL)
                            ->setEntityId($entity->getId())
                            ->generateUrl();
                        return sprintf('<a href="%s">%s</a>', $url, $value);
                    })
                    ->setSortable(true),
                IntegerField::new('brandCount', 'nombre de marques')
                    ->setTextAlign("center")
                    ->setSortable(false),
                ImageField::new('icon', 'Icon') 
                    ->setBasePath('/images/brands/categories'),
            ];
        }

        if($pageName === Crud::PAGE_NEW || $pageName === Crud::PAGE_EDIT){
            $fields = [
                TextField::new("name",'title'),
                TextField::new('File') 
                    ->setFormType(VichImageType::class),
            ];
        }

        if($pageName === Crud::PAGE_DETAIL){
            $fields = [
                IdField::new('id'),
                TextField::new("name",'title'),
                DateTimeField::new('_updatedAt', "last update"),
                ImageField::new('icon', 'Icon') 
                    ->setBasePath('/images/brands/categories'),
                AssociationField::new('brands', "Marques")
                    ->setTemplatePath('admin/fields/brandsTable.html.twig'),
            ];
        }

        

        
        return $fields;
    }


}
