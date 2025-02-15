<?php

namespace App\Controller\Public;

use App\Entity\Family;
use App\Repository\FamilyCategoryRepository;
use App\Repository\FamilyRepository;
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

    #[Route('/family/{slug}', name: 'public_family_category', requirements: ['slug' => '[a-z0-9-]+'])]
    public function category(FamilyRepository $familyRepository, FamilyCategoryRepository $familyCategoryRepository, string $slug): Response
    {
        $familyCategory = $familyCategoryRepository->findBy(['slug' => $slug]);
        $family = $familyRepository->findBy(['familyCategory' => $familyCategory]);
        return $this->render('Public/family/category.html.twig', [
            'slug' => $family,
        ]);
    }
}
