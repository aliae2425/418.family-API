<?php

namespace App\DTO\Admin;

use DateTime;
use DateTimeImmutable;

class BrandIndexDTO
{

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $category,
        public readonly DateTimeImmutable $createdAt,
        public readonly DateTimeImmutable $updatedAt,
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

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}