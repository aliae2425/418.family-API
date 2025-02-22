<?php

namespace App\Entity;

use App\Repository\FamilyCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Cast\Array_;
use TailwindMerge\Support\Arr;

// use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: FamilyCategoryRepository::class)]
// #[Broadcast]
class FamilyCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $_createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $_updatedAt = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'child')]
    private ?self $parents = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parents')]
    private Collection $child;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @var Collection<int, Family>
     */
    #[ORM\OneToMany(targetEntity: Family::class, mappedBy: 'familyCategory')]
    private Collection $families;

    #[ORM\Column]
    private ?int $level = null;

    public function __construct()
    {
        $this->child = new ArrayCollection();
        $this->families = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getParents(): ?self
    {
        return $this->parents;
    }

    public function setParents(?self $parents): static
    {
        $this->parents = $parents;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChild(): Collection
    {
        return $this->child;
    }

    public function addChild(self $child): static
    {
        if (!$this->child->contains($child)) {
            $this->child->add($child);
            $child->setParents($this);
        }

        return $this;
    }

    public function removeChild(self $child): static
    {
        if ($this->child->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParents() === $this) {
                $child->setParents(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

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
            $family->setFamilyCategory($this);
        }

        return $this;
    }

    public function removeFamily(Family $family): static
    {
        if ($this->families->removeElement($family)) {
            // set the owning side to null (unless already changed)
            if ($family->getFamilyCategory() === $this) {
                $family->setFamilyCategory(null);
            }
        }

        return $this;
    }

    public function getFamilyCount(): int
    {
        return $this->families->count();
    }

    public function getChildCount(): int
    {
        return $this->child->count();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }
}
