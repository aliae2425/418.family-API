<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    #[Route(path: '/register/entreprise', name: 'app_register')]
    public function registerEntreprise()
    {
        //todo
    }

    #[Route(path: '/entreprise/{id}/create/user', name: 'family.register')]
    public function registerCompanyUser(EntityManagerInterface $em)
    {
        //todo
    }


    #[Route(path: '/register', name : 'user.register', methods: ['GET', 'POST'])]
    public function register(EntityManagerInterface $em): Response
    {
        // $user = new User();
        // $form = $this->createForm(UserType::class, $user);

        // // dd($form->isSubmitted());

        // if($form->isSubmitted() && $form->isValid()){
        //     dd($user);
        //     $em->persist($user);
        //     $em->flush();
        //     return $this->redirectToRoute('app_login');
        // }

        return $this->render('security/register.html.twig');
    }
}
