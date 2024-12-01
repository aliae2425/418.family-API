<?php

namespace App\Controller\Admin;

use App\Repository\BrandsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/brands', 'admin.brands.')]
class BrandsController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(BrandsRepository $brandsRepo): Response
    {
        // $brands = $brandsRepo->index();
        return $this->render('admin/brands/index.html.twig', [
            'brands' => $brandsRepo->index()
        ]);
    }
}
