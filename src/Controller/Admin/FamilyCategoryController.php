<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin/family/category', name: 'admin.family.category.')]
class FamilyCategoryController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('admin/family_category/index.html.twig', [
            'controller_name' => 'FamilyCategoryController',
        ]);
    }
}
