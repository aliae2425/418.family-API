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

    #[ORM\OneToOne(inversedBy: 'familyCollection', cascade: ['persist', 'remove'])]
    private ?User $User = null;

    /**
     * @var Collection<int, Family>
     */
    #[ORM\ManyToMany(targetEntity: Family::class)]
    private Collection $families;

    #[ORM\Column]
    private ?\DateTimeImmutable $_createdAt = null;

    public function __construct()
    {
        $this->families = new ArrayCollection();
    }

    public function getFamilyCount(): int
    {
        if ($this->families == null) {
            return 0;
        }
        return $this->families->count();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Family>
     */
    public function getFamilies(): Collection
    {
        return $this->families;
    }

    public function addFamily(Family $family): static
    {
        if (!$this->families->contains($family)) {
            $this->families->add($family);
        }

        return $this;
    }

    public function removeFamily(Family $family): static
    {
        $this->families->removeElement($family);

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
}
