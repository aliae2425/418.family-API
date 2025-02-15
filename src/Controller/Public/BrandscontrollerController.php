<?php

namespace App\Controller\Public;

use App\Repository\BrandsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BrandscontrollerController extends AbstractController
{
    #[Route('/Fourniseurs', name: 'public_brands_index')]
    public function index(BrandsRepository $brandsRepo): Response
    {
        $brands = $brandsRepo->findAllPaginated(1,25);
        return $this->render('brandscontroller/index.html.twig', [
            'controller_name' => 'BrandscontrollerController',
        ]);
    }
}
