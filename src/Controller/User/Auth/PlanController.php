<?php

namespace App\Controller\User\Auth;

use App\Entity\Business;
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
    public function confirm($choice, EntityManagerInterface $em): Response
    {
        switch ($choice) {
            case 'free':
                $this->addFlash('success', 'welcome to the free plan');
                break;
            case 'premium':
                $this->addFlash('success', 'welcome to the free plan');
                //todo: add user logic to upgrade to premium plan
                break;
            case 'business':
                $user = $this->getUser();
                $business = new Business();
                $business->setOwner($user);
                $business->setActiveStatus(true);
                $em->persist($business);
                $this->addFlash('success', 'votre entreprise a été créée avec succès, vous pouvez maintenant ajouter des utilisateurs');
                break;
        }
        $em->flush();
        return $this->redirectToRoute('user_profile');
    }
}
