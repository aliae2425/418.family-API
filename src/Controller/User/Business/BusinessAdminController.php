<?php

namespace App\Controller\User\Business;

use App\Entity\RegistrationInvitation;
use App\Form\BusinessUsersType;
use App\Form\RegistrationFormType;
use App\Repository\BusinessRepository;
use App\Repository\RegistrationInvitationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Requirement\Requirement;

class BusinessAdminController extends AbstractController
{
    #[Route('/business/admin', name: 'User_business_admin')]
    public function index(BusinessRepository $repo, Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $user = $this->getUser();
        $business = $repo->findOneBy(['owner' => $user]);
        $users = $business->getUsers();

        $form = $this->createForm(BusinessUsersType::class);
        $form->handleRequest($request);

        dump($form->isSubmitted(), $form->getData());
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $invitation = new RegistrationInvitation($data['email'], $data['roles'], $business);
            
            $em->persist($invitation);
            $em->flush();

            // Envoi de l'email
            $url = $this->generateUrl('registration_confirm', ['token' => $invitation->getToken()], UrlGeneratorInterface::ABSOLUTE_URL);
            $email = (new TemplatedEmail())
                ->from('truc@example.com')
                ->to($data['email'])
                ->subject('Vous avez été invité à rejoindre l\'application')
                ->htmlTemplate('User/Auth/registration/invitation.html.twig')
                ->context([
                    'url' => $url
                ]);

            $mailer->send($email);

            $this->addFlash('success', 'Utilisateur ajouté avec succès et email envoyé.');
            return $this->redirectToRoute('User_business_admin');
        }

        return $this->render('User/Business/admin.html.twig', [
            'business' => $business,
            'users' => $users,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/register/invitation/{token}', name: 'registration_confirm')]
    public function confirmInvitation($token, Request $request, EntityManagerInterface $em, RegistrationInvitationRepository $repo): Response
    {
        $invitation = $repo->findOneBy(['token' => $token]);

        if (!$invitation) {
            throw $this->createNotFoundException('Invitation introuvable');
        }

        dump($invitation);
        $form = $this->createForm(RegistrationFormType::class);
        $form->get('email')->setData($invitation->getEmail());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setRoles([$invitation->getRole()]);
            $user->setBusiness($invitation->getBusiness());
            $user->setEmail($invitation->getEmail());

            $em->persist($user);
            $em->remove($invitation);
            $em->flush();

            $this->addFlash('success', 'Votre compte a été créé avec succès.');
            return $this->redirectToRoute('public.home');
        }

        return $this->render('User/Auth/registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

}
