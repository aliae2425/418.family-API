<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin/dashboard', name: 'admin.dashboard.')]
class DashboardController extends AbstractController
{
    #[Route('/analytics', name: 'analytics')]
    public function analytics(): Response
    {
        return $this->render('admin/dashboard/index.html.twig', );
    }

    #[Route('/ecommerce', name: 'ecommerce')]
    public function ecommerce(): Response
    {
        return $this->render('admin/dashboard/index.html.twig', );
    }
}
