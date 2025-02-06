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
        $assets = $FamillyRepo->findAllPaginated(1,25);

        return $this->render('Public/asset_browser/index.html.twig', [
            'items' => $assets,
            'familyCategory' => $familyCategory
        ]);
    }

    #[Route('/familles/{slug}', name: 'asset_browser_family', requirements:['slug' => '[a-z0-9-]+'])]
    public function category(FamilyRepository $familyRepository, FamilyCategoryRepository $familyCategoryRepository, string $slug): Response
    {
        $familyCategory = $familyCategoryRepository->findBy(['slug' => $slug])[0];
        if (!$familyCategory) {
            throw $this->createNotFoundException('La catégorie n\'existe pas');
        }
        $family = $familyRepository->findByPaginate($familyCategory, 1, 25);

        if ($familyCategory->getParents() === null) {
            $familyCategory = $familyCategoryRepository->findBy(['parents' => null]);
        }else{
            $familyCategory = $familyCategoryRepository->findBy(['id' => $familyCategory->getParents()]);
        }
        // dd($family);
        return $this->render('Public/asset_browser/index.html.twig', [
            'familyCategory' => $familyCategory,
            'items' => $family,
        ]);
    }
}       
