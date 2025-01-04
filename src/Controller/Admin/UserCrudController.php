<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\AdressType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::DELETE);
    }

    public function createEntity(string $entityFqcn)
    {
        $user = new User();
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setLastActivity(new \DateTimeImmutable());
        $user->setCoins(0);
        return $user;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setLastActivity(new \DateTimeImmutable());
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setLastActivity(new \DateTimeImmutable());
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setSearchFields(['id', 'email', 'lastActivity' , 'coins'])
            ->setDefaultSort(['id' => 'DESC']);
    }


    public function configureFields(string $pageName): iterable
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        
        if($pageName === Crud::PAGE_INDEX){
            $fields = [
                IdField::new('id', 'ID'),
                UrlField::new('email')
                    ->formatValue(function ($value, $entity) use ($adminUrlGenerator) {
                        $url = $adminUrlGenerator
                            ->setController(UserCrudController::class)
                            ->setAction(Action::DETAIL)
                            ->setEntityId($entity->getId())
                            ->generateUrl();
                        return sprintf('<a href="%s">%s</a>', $url, $value);
                    })
                    ->setSortable(true),
                DateField::new('createdAt', "date de creation")
                    ->setSortable(true),
                DateField::new('lastActivity', "derniere activité")
                    ->setSortable(true),
                IntegerField::new('familyCount', 'Nombre de famille')
                    ->setTextAlign('center')
                    ->setSortable(false),
                IntegerField::new('coins')
                    ->setSortable(true),
                BooleanField::new('isVerified'),
            ];
        }

        if($pageName === Crud::PAGE_NEW || $pageName === Crud::PAGE_EDIT){
            $fields = [
                TextField::new('email'),
                IntegerField::new('coins'),
                CollectionField::new('adresses')
                    ->setEntryType(AdressType::class)
                    ->allowAdd(true)
                    ->allowDelete(true)
                    ->setFormTypeOptions([
                        'by_reference' => false,
                    ]),
            ];
        }

        if($pageName === Crud::PAGE_DETAIL){
            $fields = [
                IdField::new('id', 'ID'),
                TextField::new('email'),
                DateField::new('createdAt', "date de creation"),
                DateField::new('lastActivity', "derniere activité"),
                IntegerField::new('familyCount', 'Nombre de famille'),
                IntegerField::new('coins'),
                AssociationField::new('adresses', "Adresses"),
            ];
        }

        
        return $fields;
    }


}
