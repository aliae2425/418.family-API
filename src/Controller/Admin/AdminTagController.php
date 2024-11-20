<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/tag', name: 'admin.tag.')]
class AdminTagController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(TagRepository $tag): Response
    {

        return $this->render('Admin/Tag/index.html.twig', [
            'tags' => $tag->findAll(),
        ]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $tag = new Tag();
        $form =  $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tag);
            $em->flush();
            $this->addFlash('success', 'Tag ajouté avec succès');
            return $this->redirectToRoute('admin.tag.index');
        }

        return $this->render('Admin/Tag/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'edit', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function edit(Tag $tag, Request $request, EntityManagerInterface $em): Response
    {
        $form =  $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Tag modifié avec succès');
            return $this->redirectToRoute('admin.tag.index');
        }

        return $this->render('Admin/Tag/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(Tag $tag, EntityManagerInterface $em): Response
    {
        $em->remove($tag);
        $em->flush();
        $this->addFlash('success', 'Tag supprimé avec succès');
        return $this->redirectToRoute('admin.tag.index');
    }

}
