<?php

namespace App\Controller\Admin;

use App\Entity\Fabricant;
use App\Form\BrandType;
use App\Repository\FabricantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/brands', name: 'admin.brand.')]  
class AdminBrandsController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(FabricantRepository $fabricantRepository): Response
    {
        // dd($fabricantRepository->index());
        return $this->render('Admin/Brand/index.html.twig', [
            'brands' => $fabricantRepository->index(),
        ]);
    }

    #[Route('/new', name: 'add', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $brand = new Fabricant();
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);
        // dd($form->isValid());
        if ($form->isSubmitted() && $form->isValid()) {
            $brand->setSlug($form->get('name')->getData());
            $em->persist($brand);
            $em->flush();
            $this->addFlash('success', 'Marque ajoutée avec succès');
            return $this->redirectToRoute('admin.brand.home');
        }

        
        return $this->render('Admin/Brand/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(Fabricant $fabricant, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(BrandType::class, $fabricant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Marque modifiée avec succès');
            return $this->redirectToRoute('admin.brand.home');
        }

        return $this->render('Admin/Brand/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
