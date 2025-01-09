<?php

namespace App\Controller\Public;

use App\Entity\Family;
use App\Repository\FamilyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AssetBrowserController extends AbstractController
{
    #[Route('/familles', name: 'public_asset_index')]
    public function index(FamilyRepository $repo): Response
    {
        $assets = $repo->findAll();

        return $this->render('Public/asset_browser/index.html.twig', [
            'items' => $assets,
        ]);
    }
}
