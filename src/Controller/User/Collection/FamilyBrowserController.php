<?php

namespace App\Controller\User\Collection;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\Business;
use App\Entity\User;

class FamilyBrowserController extends AbstractController
{

    #[IsGranted('ROLE_USER')]
    #[Route('/profile/collection', name: 'app_family_browser')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page.');
            return $this->redirectToRoute('app_login');
        }

        if($user->getRelatedBusiness() != null){
            $items = $user->getRelatedBusiness()->getOwner()->getFamilliesCollection();
        }else{
            $items = $user->getFamilliesCollection();
        }


        return $this->render('User/Collection/family_browser/index.html.twig', [
            'items' => $items,
        ]);
    }
}
