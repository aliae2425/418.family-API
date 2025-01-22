<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

final class LoginListener
{

    
    public function __construct(
        private EntityManagerInterface $em,
        private Security $security
    )
    {
        // ...
    }

    #[AsEventListener(event: 'security.authentication.success')]
    public function onSecurityAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $user = $this->security->getUser();
        if($user === null) {
            return;
        }else{
            $user->setLastActivity(new \DateTimeImmutable());
            $this->em->persist($user);
            $this->em->flush();
        }
    }
}
