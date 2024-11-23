<?php

namespace App\DTO\Admin;

class BrandCategoryaIndexDTO
{

    public function __construct(
        private readonly int $id,
        private readonly string $title,
        private readonly int $BrandsCount,
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

    public function getBrandsCount(): int
    {
        return $this->BrandsCount;
    }

}