<?php

namespace App\Controller\Admin;

use App\Entity\BrandCategory;
use App\Form\BrandCategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/brand/categories', 'admin.brand.categories.')]
class BrandCategoryController extends AbstractController
{

    //todo: add category show

    //ok
    #[Route('/add', name: 'add', methods:['GET','POST'])]
    public function addCategory(Request $request, EntityManagerInterface $em): Response
    {
        $category = new BrandCategory();
        $form = $this->createForm(BrandCategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', $category->getName().' ajouté');
            return $this->redirectToRoute('admin.brands.home');
        }else if($form->isSubmitted() && !$form->isValid()){
            $this->addFlash('danger', 'Erreur lors de l\'ajout');
        }

        return $this->render('admin/brands/brandCategoryForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //ok
    #[Route('/{id}/edit', name: 'edit', methods:['GET','POST'], requirements:['id' => '\d+'])]
    public function editCategory(Request $request, BrandCategory $category, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(BrandCategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', $category->getName().' mis à jour');
            return $this->redirectToRoute('admin.brands.home');
        }else if($form->isSubmitted() && !$form->isValid()){
            $this->addFlash('danger', 'Erreur lors de la mise à jour');
        }

        return $this->render('admin/brands/brandCategoryForm.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //todo: fixe delete no response
    #[Route('/{id}/delete', name: 'delete', methods:['DELETE'], requirements:['id' => Requirement::DIGITS])]
    public function deleteCategory(BrandCategory $category, EntityManagerInterface $em): Response
    {
        $em->remove($category);
        $em->flush();
        $this->addFlash('success', 'category supprimé');

        return $this->redirectToRoute('admin.brands.home');
    }
}
