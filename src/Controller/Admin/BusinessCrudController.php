<?php

namespace App\Controller\Admin;

use App\Entity\Business;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use phpDocumentor\Reflection\Types\Integer;

class BusinessCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Business::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            AssociationField::new('owner', 'Propriétaire'),
            DateTimeField::new('createdAt', 'Date de Création'),
            BooleanField::new('activeStatus', 'Statut Actif'),
            IntegerField::new('usersCount', 'Nombre d\'Utilisateurs'),
            IntegerField::new('pendingInvitations', 'Nombre d\'Invitations en Attente'),
        ];
    }

}
