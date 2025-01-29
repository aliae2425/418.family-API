<?php

namespace App\Controller\Public;

use App\Entity\Family;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FamilyController extends AbstractController
{
    #[Route('/family', name: 'app_family')]
    public function index(): Response
    {
        return $this->render('family/index.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    #[Route('/family/{id}', name: 'public_family_show', requirements: ['id' => '\d+'])]
    public function show(Family $family): Response
    {
        return $this->render('Public/family/show.html.twig', [
            'slug' => $family,
        ]);
    }
}
