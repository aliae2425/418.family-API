<?php

namespace App\Entity;

use App\Repository\BusinessRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BusinessRepository::class)]
class Business
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'busines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $_createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $_updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->_createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $_createdAt): static
    {
        $this->_createdAt = $_createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->_updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $_updatedAt): static
    {
        $this->_updatedAt = $_updatedAt;

        return $this;
    }
}
