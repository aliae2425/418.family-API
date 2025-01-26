<?php

namespace App\Controller\Public;

use App\Entity\Family;
use App\Entity\FamilyCategory;
use App\Repository\FamilyCategoryRepository;
use App\Repository\FamilyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AssetBrowserController extends AbstractController
{
    #[Route('/familles', name: 'public_asset_index')]
    public function index(FamilyRepository $Famillyrepo, FamilyCategoryRepository $familyCategoryRepository): Response
    {
        
        $assets = $Famillyrepo->findAll();
        $familyCategoryRepository = $familyCategoryRepository->findAll();

        return $this->render('Public/asset_browser/index.html.twig', [
            'items' => $assets,
            'familyCategory' => $familyCategoryRepository
        ]);
    }

    #[Route('/familles/{id}', name: 'public_asset_show')]
    public function show(Family $family): Response
    {
        return $this->render('Public/asset_browser/show.html.twig', [
            'family' => $family
        ]);
    }


    #[Route('/familles/{slug}', name: 'asset_browser_family')]
    public function family(FamilyCategory $familyCategory): Response
    {
        $family = $familyCategory->getFamilies();
        return $this->render('Public/asset_browser/family.html.twig', [
            'family' => $family
        ]);
    }
}
