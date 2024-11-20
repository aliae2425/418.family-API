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
class AdminMarqueController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(FabricantRepository $fabricantRepository): Response
    {
        return $this->render('Admin/Brand/index.html.twig', [
            'Marques' => $fabricantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'add', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(BrandType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $brand = new Fabricant();
            /** @var UploadedFile */
            $file = $form->get('thumbnailFile')->getData();
            $fileName = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
            dd($fileName);
            //todo : Gestion de l'upload de fichier
            $em->persist($form->getData());
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
            /** @var UploadedFile */
            $file = $form->get('thumbnailFile')->getData();
            //todo : Gestion de l'upload de fichier
            $em->flush();
            $this->addFlash('success', 'Marque modifiée avec succès');
            return $this->redirectToRoute('admin.brand.home');
        }

        return $this->render('Admin/Brand/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
