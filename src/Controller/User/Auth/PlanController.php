<?php

namespace App\Controller\User\Auth;

use App\Entity\Business;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlanController extends AbstractController
{
    #[Route('/plan', name: 'user_plan')]
    public function index(): Response
    {
        return $this->render('User/Auth/registration/plan.html.twig');
    }

    #[Route('/plan/{choice}', name: 'user_plan_confirm', requirements: ['choice' => 'free|premium|business'])]
    public function confirm($choice, UserRepository $repo, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page.');
            return $this->redirectToRoute('app_login');
        }else{
            $user = $repo->find($user->getId());
            $user->setPlan($choice);
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Votre plan a été mis à jour avec succès');
            return $this->redirectToRoute('user_profile');
        }
    }
}
