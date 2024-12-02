<?php

namespace App\Controller\Admin;

use App\Entity\BrandCategory;
use App\Entity\Brands;
use App\Form\BrandCategoryType;
use App\Form\BrandType;
use App\Repository\BrandCategoryRepository;
use App\Repository\BrandsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/brands', 'admin.brands.')]
class BrandsController extends AbstractController
{
    //ok
    #[Route('/', name: 'home')]
    public function index(BrandsRepository $brandsRepo, BrandCategoryRepository $brandCategoryRepo): Response
    {
        return $this->render('admin/brands/index.html.twig', [
            'brands' => $brandsRepo->index(),
            'categories' => $brandCategoryRepo->index()
        ]);
    }

    //ok
    #[Route('/{id}', name: 'show', requirements:['id' => Requirement::DIGITS])]
    public function show(Brands $brand): Response
    {
        return $this->render('admin/brands/show.html.twig', [
            'brand' => $brand
        ]);
    }

    //ok
    #[Route('/{id}/edit', name: 'edit', methods:['GET','POST'],  requirements:['id' => '\d+'])]
    public function edit(Request $request, Brands $brand, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', $brand->getName().' mis à jour');
            return $this->redirectToRoute('admin.brands.home');
        }

        return $this->render('admin/brands/brandForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //ok
    #[Route('/add', name: 'add', methods:['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $brand = new Brands();
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($brand);
            $em->flush();
            $this->addFlash('success', $brand->getName().' ajouté');
            return $this->redirectToRoute('admin.brands.home');
        }else{
            $this->addFlash('danger', 'Erreur lors de l\'ajout');
        }

        return $this->render('admin/brands/brandForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //ok
    #[Route('/{id}/delete', name: 'delete', requirements:['id' => '\d+'])]
    public function delete(Request $request, Brands $brand, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brand->getId(), $request->request->get('_token'))) {
            $em->remove($brand);
            $em->flush();
            $this->addFlash('success', $brand->getName().' supprimé');
        }else{
            $this->addFlash('danger', 'Erreur lors de la suppression');
        }

        return $this->redirectToRoute('admin.brands.home');
    }


}
