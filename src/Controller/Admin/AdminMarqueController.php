<?php

namespace App\Controller\Admin;

use App\Entity\Fabricant;
use App\Repository\FabricantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/marque', name: 'admin.marque.')]  
class AdminMarqueController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(FabricantRepository $fabricantRepository): Response
    {
        return $this->render('admin_marque/index.html.twig', [
            'Marques' => $fabricantRepository->findAll(),
        ]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(EntityManagerInterface $em): Response
    {
        $Marque = new Fabricant();

        
        return $this->render('admin_marque/create.html.twig');
    }

}
