<?php

namespace App\DTO\Admin;

use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;

class BrandIndexDTO
{

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly Collection $category,
        public readonly DateTimeImmutable $createdAt,
        public readonly DateTimeImmutable $updatedAt,
        public readonly int $links
    ){}
}