<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/category', name: 'admin.category.')]
class AdminCategoryController extends AbstractController
{

    #[Route('/', name: 'home')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $cat = $categoryRepository->findAll();
        return $this->render('Admin/admin_category/index.html.twig', [
            'categories' => $cat,
        ]);
    }

    #[Route('/create', name: 'add')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Catégorie ajoutée avec succès');
            return $this->redirectToRoute('admin.category.index');
        }

        return $this->render('Admin/admin_category/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'edit', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function edit(Category $category, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Catégorie modifiée avec succès');
            return $this->redirectToRoute('admin.category.index');
        }

        return $this->render('Admin/admin_category/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS], methods: ['DELETE'])]
    public function delete(Category $category, EntityManagerInterface $em): Response
    {
        $em->remove($category);
        $em->flush();
        $this->addFlash('success', 'Catégorie supprimée avec succès');
        return $this->redirectToRoute('admin.category.index');
    }

}
