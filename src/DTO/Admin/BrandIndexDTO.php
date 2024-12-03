<?php

namespace App\DTO\Admin;

class BrandIndexDTO
{

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $category,
        public readonly int $links
    ){}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getLinks(): int
    {
        return $this->links;
    }
}