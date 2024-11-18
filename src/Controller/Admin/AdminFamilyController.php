<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/family', name: 'admin.family.')]
class AdminFamilyController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('Admin/admin_family/index.html.twig', [
            'controller_name' => 'AdminFamilyController',
        ]);
    }
}
