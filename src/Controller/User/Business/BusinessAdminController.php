<?php

namespace App\Controller\User\Business;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BusinessAdminController extends AbstractController
{
    #[Route('/business/admin', name: 'User_business_admin')]
    public function index(): Response
    {
        return $this->render('User/Business/admin.html.twig');
    }
}
