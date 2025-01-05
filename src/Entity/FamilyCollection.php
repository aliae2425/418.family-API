<?php

namespace App\Entity;

use App\Repository\FamilyCollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FamilyCollectionRepository::class)]
class FamilyCollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $_createdAt = null;

    #[ORM\OneToOne(inversedBy: 'familyCollection', cascade: ['persist', 'remove'])]
    private ?User $User = null;

    #[ORM\OneToOne(inversedBy: 'familyCollection', cascade: ['persist', 'remove'])]
    private ?Family $family = null;

    public function __construct()
    {
        $this->_createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->_createdAt;
    }

    public function setCreatedAt(): static
    {
        $this->_createdAt = new \DateTimeImmutable();

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getFamily(): ?Family
    {
        return $this->family;
    }

    public function setFamily(?Family $Family): static
    {
        $this->family = $Family;

        return $this;
    }
    
}
