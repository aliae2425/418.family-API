<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserCollection;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface, OrderedFixtureInterface
{

    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder
    ){}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            $collection = new UserCollection();
            $collection->addUser($user);
            $collection->setOwner($user);
            $collection->setCoins($faker->numberBetween(0, 1000));
            $user->setEmail($faker->email());
            $user->setPassword(
                $this->passwordEncoder->hashPassword(
                    $user,
                    $faker->password()
                    )
                );
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years', 'now')));
            $user->setLastActivity(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-100 days', 'now')));
            $user->setVerified($faker->boolean(90));
            $user->setStatus($faker->boolean(90));

            $manager->persist($collection);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['user'];
    }

    public function getOrder(): int
    {
        return 5;
    }

}
