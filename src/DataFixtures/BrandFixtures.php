<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;

class BrandFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        $categories = $manager->getRepository(\App\Entity\BrandCategory::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $brand = new \App\Entity\Brands();
            $slugger = new AsciiSlugger();
            $brand->setName($faker->company());
            $brand->setSlug(strtolower($slugger->slug($brand->getName())));
            $brand->setCreatedAt(new \DateTimeImmutable());
            $brand->setUpdatedAt(new \DateTimeImmutable());
            
            // Add 1-3 random categories
            $numCategories = rand(1, 3);
            $randomCategories = $faker->randomElements($categories, $numCategories);
            foreach ($randomCategories as $category) {
                $brand->addCategory($category);
            }

            $manager->persist($brand);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }

}
