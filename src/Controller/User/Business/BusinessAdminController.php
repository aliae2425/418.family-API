<?php

namespace App\Controller\User\Business;

use App\Entity\RegistrationInvitation;
use App\Entity\User;
use App\Form\BusinessUsersType;
use App\Form\InvitationFormType;
use App\Repository\BusinessRepository;
use App\Repository\RegistrationInvitationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class BusinessAdminController extends AbstractController
{
    #[IsGranted('ROLE_USER')]   
    #[Route('/business/admin', name: 'User_business_admin' )]
    public function index(BusinessRepository $repo, Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page.');
            return $this->redirectToRoute('app_login');
        }

        $business = $repo->findOneBy(['owner' => $user]);
        $form = $this->createForm(BusinessUsersType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $invitation = new RegistrationInvitation($data['email'], $data['roles'], $business, $user->getUserCollection());
            
            $em->persist($invitation);
            $em->flush();

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
            'form' => $form->createView(),
        ]);
    }

    #[Route('/register/invitation/{token}', name: 'registration_confirm')]
    public function confirmInvitation(
                        string $token,
                        Request $request,
                        UserPasswordHasherInterface $userPasswordHasher,
                        EntityManagerInterface $em,
                        RegistrationInvitationRepository $repo
                ): Response
    {
        $invitation = $repo->findOneBy(['token' => $token]);

        if (!$invitation) {
            throw $this->createNotFoundException('Invitation introuvable');
        }

        dump($invitation);
        $user = new User();
        $form = $this->createForm(InvitationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            $collection  = $invitation->getCollection();
            $collection->addUser($user);

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));           
            $user->setRoles([$invitation->getRole()]);
            $user->setRelatedBusiness($invitation->getBusiness());
            $user->setEmail($invitation->getEmail());
            $user->setVerified(true);

            $em->persist($collection);
            $em->persist($user);

            $invitation->close();
            $em->persist($invitation);

            $em->flush();

            $this->addFlash('success', 'Votre compte a été créé avec succès.');
            return $this->redirectToRoute('public.home');
        }

        return $this->render('User/Auth/registration/registerInvitation.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/Profile/Business/Settings', name: 'User_business_settings')]
    public function BusinessSettings(): Response
    {
        return $this->render('User/Business/settings.html.twig');
    }

}
