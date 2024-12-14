<?php

namespace App\Controller\Admin;

use App\Entity\FamilyCategory;
use App\Form\FamilyCategoryType;
use App\Repository\FamilyCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('admin/family/category', name: 'admin.family.categories.')]
class FamilyCategoryController extends AbstractController
{
    //ok
    #[Route('/', name: 'home')]
    public function index(FamilyCategoryRepository $familyCategoryRepository): Response
    {
        $familyCategories = $familyCategoryRepository->findAll();
        return $this->render('admin/family_category/index.html.twig', [
            'categories' => $familyCategories,
        ]);
    }

    //todo : test this function
    #[Route('/{id}', name: 'show', requirements:['id' => Requirement::DIGITS])]
    public function show(FamilyCategory $familyCategory): Response
    {
        return $this->render('admin/family_category/show.html.twig', [
            'category' => $familyCategory,
        ]);
    }

    //ok
    #[Route('/add', name: 'add')]
    public function addFamilyCategory(Request $request, EntityManagerInterface $entityManager): Response
    {
        $familyCategory = new FamilyCategory();
        $form = $this->createForm(FamilyCategoryType::class, $familyCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $familyCategory->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($familyCategory);
            $entityManager->flush();
            $this->addFlash('success', $familyCategory->getName().' créee');
            return $this->redirectToRoute('admin.family.categories.home');
        }

        return $this->render('admin/family_category/FamilyCategoryForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //todo : exclude the current category from the list of parents
    #[Route('/{id}/edit', name: 'edit', methods:['GET', 'POST'], requirements:['id' => Requirement::DIGITS])]
    public function edit(Request $request, FamilyCategory $familyCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FamilyCategoryType::class, $familyCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($familyCategory);
            $entityManager->flush();
            $this->addFlash('success', $familyCategory->getName().' modifiée');
            return $this->redirectToRoute('admin.family.categories.home');
        }

        return $this->render('admin/family_category/FamilyCategoryForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //todo : test this function
    #[Route('/{id}/delete', name: 'delete', requirements:['id' => Requirement::DIGITS])]
    public function delete(Request $request, FamilyCategory $familyCategory, EntityManagerInterface $entityManager): Response
    {
        // if ($this->isCsrfTokenValid('delete'.$familyCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($familyCategory);
            $entityManager->flush();
            $this->addFlash('success', $familyCategory->getName().' supprimée');
        // }
        return $this->redirectToRoute('admin.family.categories.home');

    }
}
