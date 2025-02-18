<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ApiTokenManager
{
    private $entityManager;
    private $params;

    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $params)
    {
        $this->entityManager = $entityManager;
        $this->params = $params;
    }

    public function generateToken(User $user): string
    {
        $token = bin2hex(random_bytes(32));
        $expiresAt = new \DateTimeImmutable('+' . $this->params->get('api_token_expiration'));

        $user->setApiToken($token);
        $user->setApiTokenExpiresAt($expiresAt);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $token;
    }

    public function isTokenValid(string $token): bool
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['apiToken' => $token]);

        if (!$user) {
            return false;
        }

        return $user->getApiTokenExpiresAt() > new \DateTime();
    }

    public function invalidateToken(User $user): void
    {
        $user->setApiToken(null);
        $user->setApiTokenExpiresAt(null);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
