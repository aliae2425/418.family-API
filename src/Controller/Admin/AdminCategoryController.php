<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminCategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'app_admin_category')]
    public function index(): Response
    {
        return $this->render('Admin/admin_category/index.html.twig', [
            'controller_name' => 'AdminCategoryController',
        ]);
    }
}
