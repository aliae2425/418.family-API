<?php

namespace App\DataFixtures;

use App\Entity\Family;
use App\Entity\FamilyCategory;
use App\Entity\Brands;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class FamilyFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $brands = $manager->getRepository(Brands::class)->findAll();
        $categories = $manager->getRepository(FamilyCategory::class)->findAll();    

        for ($i = 1; $i <= 25; $i++) {
            $family = new Family();
            $family->setName($faker->word());
            $family->setCreatedAt(new DateTimeImmutable());
            $family->setUpdatedAt(new DateTimeImmutable());
            $family->setRevitFamily('418_TeaPot.rfa');

            $family->setFamilyCategory($faker->randomElement($categories));
            $family->setBrand($faker->randomElement($brands));

            $manager->persist($family);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['family'];
    }
    
}

