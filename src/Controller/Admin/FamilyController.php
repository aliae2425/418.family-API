<?php

namespace App\Controller\Admin;

use App\Entity\Family;
use App\Form\FamilyType;
use App\Repository\FamilyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin/family', name: 'admin.family.')]
class FamilyController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(FamilyRepository $repo): Response
    {

        return $this->render('admin/family/index.html.twig', [
            'famillies' => $repo->findAll(),
        ]);
    }

    #[Route('/add', name: 'add', methods:['GET','POST'])]
    public function addFamily(Request $request, EntityManagerInterface $em): Response
    {
        $family = new Family();
        $form = $this->createForm(FamilyType::class, $family);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $family->setCreatedAt(new \DateTimeImmutable());
            $em->persist($family);
            $em->flush();
            $this->addFlash('success', $family->getName().' ajouté');
            return $this->redirectToRoute('admin.family.home');
        }

        return $this->render('admin/family/familyForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods:['GET','POST'], requirements:['id' => '\d+'])]
    public function editFamily(Request $request, Family $family, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(FamilyType::class, $family);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', $family->getName().' mis à jour');
            return $this->redirectToRoute('admin.family.home');
        }else if($form->isSubmitted() && !$form->isValid()){
            $this->addFlash('danger', 'Erreur dans le formulaire');
        }

        return $this->render('admin/family/familyForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods:['POST'], requirements:['id' => '\d+'])]
    public function deleteFamily(Family $family, EntityManagerInterface $em): Response
    {
        if($this->isCsrfTokenValid('delete'.$family->getId(), $_POST['_token'])){
            $em->remove($family);
            $em->flush();
            $this->addFlash('success', $family->getName().' supprimé');
        }else{
            $this->addFlash('danger', 'CRSF Token invalide');
        }
        return $this->redirectToRoute('admin.family.home');
    }

}
