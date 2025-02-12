<?php
namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class TokenUserProvider implements UserProviderInterface
{
    public function loadUserByUsername(string $username): UserInterface
    {
        // Load user by token (username is the token here)
        // Implement your logic to load the user by token
        // For example, query the database to find the user by token

        // Example:
        // $user = $this->userRepository->findOneBy(['apiToken' => $username]);
        // if (!$user) {
        //     throw new UsernameNotFoundException();
        // }
        // return $user;

        throw new UsernameNotFoundException();
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException();
        }

        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }
}