<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'public.user')]
    public function index(): Response
    {

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/admin/user', name: 'admin.user')]
    public function adminIndex(UserRepository $repo): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $repo->findAll(),
        ]);
    }

    #[Route('/mail/test', name: 'mail.test')]
    public function mailTest(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->to('demo@demo.com')
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->from('you@exemple.com');

        $mailer->send($email);
        return new Response('Email was sent');
    }
}
