<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', "admin.")]
class AdminHomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('Admin/admin_home/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }
}
