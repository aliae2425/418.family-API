<?php

namespace App\Controller\User\Business;

use App\Form\BusinessUsersType;
use App\Repository\BusinessRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BusinessAdminController extends AbstractController
{
    #[Route('/business/admin', name: 'User_business_admin')]
    public function index(BusinessRepository $repo, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $business = $repo->findOneBy(['owner' => $user]);

        if ($business) {
            $users = $business->getUsers(); // This will initialize the collection
        } else {
            $users = [];
        }

        $form = $this->createForm(BusinessUsersType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Logique pour ajouter un utilisateur
            $data = $form->getData();
            $token = bin2hex(random_bytes(32));
            // Créez et enregistrez l'utilisateur ici

            $this->addFlash('success', 'Utilisateur ajouté avec succès');
            return $this->redirectToRoute('User_business_admin');
        }

        return $this->render('User/Business/admin.html.twig', [
            'business' => $business,
            'users' => $users,
            'form' => $form->createView(),
        ]);
    }
}
