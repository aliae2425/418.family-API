<?php

namespace App\Controller\Public;

use App\Entity\Family;
use App\Entity\FamilyCategory;
use App\Repository\FamilyCategoryRepository;
use App\Repository\FamilyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Required;

class AssetBrowserController extends AbstractController
{
    #[Route('/familles', name: 'public_asset_index')]
    public function index(FamilyRepository $FamillyRepo, FamilyCategoryRepository $familyCategoryRepository): Response
    {
        
        $familyCategory = $familyCategoryRepository->findBy(['parents' => null]);
        $assets = $FamillyRepo->findAll();

        return $this->render('Public/asset_browser/index.html.twig', [
            'items' => $assets,
            'familyCategory' => $familyCategory
        ]);
    }

    #[Route('/familles/{slug}', name: 'asset_browser_family', requirements:['slug' => '[a-z0-9-]+'])]
    public function category(FamilyRepository $familyRepository, FamilyCategoryRepository $familyCategoryRepository, string $slug): Response
    {
        $familyCategory = $familyCategoryRepository->findBy(['slug' => $slug]);
        $family = $familyRepository->findBy(['familyCategory' => $familyCategory]);
        return $this->render('Public/asset_browser/index.html.twig', [
            'slug' => $family,
        ]);
    }
}       
