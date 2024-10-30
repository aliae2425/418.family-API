<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminTagController extends AbstractController
{
    #[Route('/admin/tag', name: 'app_admin_tag')]
    public function index(): Response
    {
        return $this->render('Admin/admin_tag/index.html.twig', [
            'controller_name' => 'AdminTagController',
        ]);
    }
}
