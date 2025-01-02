<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{

    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder
    ){}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setPassword(
                $this->passwordEncoder->hashPassword(
                    $user,
                    $faker->password()
                    )
                );
            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years', 'now')));
            $user->setLastActivity(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-100 days', 'now')));
            $user->setCoins($faker->numberBetween(0, 1000));
            $user->setVerified($faker->boolean(90));
            $user->setStatus($faker->boolean(90));

            $manager->persist($user);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['user'];
    }

}
