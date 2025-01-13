<?php

namespace App\Controller\User\Business;

use App\Repository\BusinessRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BusinessAdminController extends AbstractController
{
    #[Route('/business/admin', name: 'User_business_admin')]
    public function index(BusinessRepository $repo): Response
    {
        $user = $this->getUser();
        $business = $repo->findOneBy(['owner' => $user]);

        if ($business) {
            $users = $business->getUsers(); // This will initialize the collection
        } else {
            $users = [];
        }

        return $this->render('User/Business/admin.html.twig', [
            'business' => $business,
            'users' => $users,
        ]);
    }
}
