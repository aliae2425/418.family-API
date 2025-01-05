<?php

namespace App\DataFixtures;

use App\Entity\Adress;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class AdressFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        $user = $manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < 100; $i++) {
            $adress = new Adress();
            $adress->setUser($faker->randomElement($user));
            $adress->setStreet($faker->streetAddress());
            $adress->setCity($faker->city());
            $adress->setPostalCode($faker->postcode());
            $adress->setCountry($faker->country());
            $adress->setCreatedAt( DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years', 'now')));
            $adress->setUpdatedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years', 'now')));

            $manager->persist($adress);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['adress', 'user'];
    }
}
