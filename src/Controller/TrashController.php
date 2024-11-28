<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TrashController extends AbstractController
{
    #[Route('/trash', name: 'app_trash')]
    public function index(): Response
    {
        return $this->render('trash/index.html.twig', [
            'controller_name' => 'TrashController',
        ]);
    }
}
