<?php 

namespace App\DTO\Admin;

class BrandsIndexDTO
{

    public function __construct(
        private readonly int $id,
        private readonly string $title,
        private readonly string $category,
        private readonly int $linkCount,
        private readonly int $familyCount,
    ){
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getLinkCount(): int
    {
        return $this->linkCount;
    }

    public function getFamilyCount(): int
    {
        return $this->familyCount;
    }


}