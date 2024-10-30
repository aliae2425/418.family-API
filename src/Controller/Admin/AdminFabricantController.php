<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminFabricantController extends AbstractController
{
    #[Route('/admin/fabricant', name: 'app_admin_fabricant')]
    public function index(): Response
    {
        return $this->render('Admin/admin_fabricant/index.html.twig', [
            'controller_name' => 'AdminFabricantController',
        ]);
    }
}
