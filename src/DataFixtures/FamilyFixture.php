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
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class FamilyFixture extends Fixture implements FixtureGroupInterface, OrderedFixtureInterface
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
            $family->setThumbnail("https://placehold.co/400");
            $family->setFamilyCategory($faker->randomElement($categories));
            $family->setPrice($faker->randomElement([0,10]));
            $family->setBrand($faker->randomElement($brands));

            $manager->persist($family);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['family'];
    }
    
    public function getOrder(): int
    {
        return 4;
    }

}

