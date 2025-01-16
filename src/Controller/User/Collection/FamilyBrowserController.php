<?php

namespace App\Controller\User\Collection;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FamilyBrowserController extends AbstractController
{
    #[Route('/profile/browser', name: 'app_family_browser')]
    public function index(): Response
    {
        return $this->render('User/Collection/family_browser/index.html.twig', [
            'controller_name' => 'FamilyBrowserController',
        ]);
    }
}
