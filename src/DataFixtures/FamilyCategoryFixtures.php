<?php

namespace App\DataFixtures;

use App\Entity\FamilyCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\String\Slugger\AsciiSlugger;

class FamilyCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $file = new Filesystem();
        $data = json_decode($file->readFile(__DIR__ . '/Data/familyCategory.json'), true);

        $this->createFamilyCategory($data, null, $manager);

        $manager->flush();
    }

    private function createFamilyCategory(array $categories, ?FamilyCategory $parent = null, ObjectManager $manager): void
    {
        foreach ($categories as $category) {
            $familyCategory = new FamilyCategory();
            $slugger = new AsciiSlugger();
            $familyCategory->setName($category['name']);
            $familyCategory->setParents($parent);
            $familyCategory->setSlug(strtolower($slugger->slug($category['name'])));
            $familyCategory->setCreatedAt(new \DateTimeImmutable());
            $familyCategory->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($familyCategory);

            if (isset($category['children'])) {
                $this->createFamilyCategory($category['children'], $familyCategory, $manager);
            }
        }
    }
}
