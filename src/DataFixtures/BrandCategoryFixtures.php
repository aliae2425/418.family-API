<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use App\Entity\BrandCategory;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class BrandCategoryFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $file = new Filesystem();
        $data = json_decode($file->readFile(__DIR__ . '/Data/brandCategory.json'), true);

        $this->createBrandCategory($data, $manager);

        $manager->flush();
    }

    private function createBrandCategory(array $categories, ObjectManager $manager): void
    {
        foreach ($categories as $category) {
            $brandCategory = new BrandCategory();
            $brandCategory->setName($category['name']);
            $brandCategory->setCreatedAt(new \DateTimeImmutable());
            $brandCategory->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($brandCategory);
        }
    }

    public function getOrder(): int
    {
        return 1;
    }
}
