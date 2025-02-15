<?php

namespace App\DataFixtures;

use App\Entity\FamilyCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\String\Slugger\AsciiSlugger;

class FamilyCategoryFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $file = new Filesystem();
        $data = json_decode($file->readFile(__DIR__ . '/Data/familyCategory.json'), true);

        $this->createFamilyCategory($data, null, $manager);

        $manager->flush();
    }

    private function createFamilyCategory(array $categories, ?FamilyCategory $parent = null, ObjectManager $manager, int $row = 0): void
    {
        foreach ($categories as $category) {
            $familyCategory = new FamilyCategory();
            $slugger = new AsciiSlugger();
            $familyCategory->setName($category['name']);
            $familyCategory->setParents($parent);
            $familyCategory->setSlug(strtolower($slugger->slug($category['name'])));
            $familyCategory->setCreatedAt(new \DateTimeImmutable());
            $familyCategory->setUpdatedAt(new \DateTimeImmutable());
            $familyCategory->setLevel($row);
            $manager->persist($familyCategory);

            if (isset($category['children'])) {
                $this->createFamilyCategory($category['children'], $familyCategory, $manager, $row + 1);
            }
        }
    }

    public function getOrder(): int
    {
        return 3;
    }
}
