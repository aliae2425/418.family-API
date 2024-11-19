<?php

namespace App\Entity;

use App\Repository\FabricantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FabricantRepository::class)]
class Fabricant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Family>
     */
    #[ORM\OneToMany(targetEntity: Family::class, mappedBy: 'fabricant')]
    private Collection $families;

    /**
     * @var Collection<int, Link>
     */
    #[ORM\OneToMany(targetEntity: Link::class, mappedBy: 'fabricant', orphanRemoval: true)]
    private Collection $lien;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sousTitre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $thumbnail = null;

    public function __construct()
    {
        $this->families = new ArrayCollection();
        $this->lien = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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
            $family->setFabricant($this);
        }

        return $this;
    }

    public function removeFamily(Family $family): static
    {
        if ($this->families->removeElement($family)) {
            // set the owning side to null (unless already changed)
            if ($family->getFabricant() === $this) {
                $family->setFabricant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Link>
     */
    public function getLien(): Collection
    {
        return $this->lien;
    }

    public function addLien(Link $lien): static
    {
        if (!$this->lien->contains($lien)) {
            $this->lien->add($lien);
            $lien->setFabricant($this);
        }

        return $this;
    }

    public function removeLien(Link $lien): static
    {
        if ($this->lien->removeElement($lien)) {
            // set the owning side to null (unless already changed)
            if ($lien->getFabricant() === $this) {
                $lien->setFabricant(null);
            }
        }

        return $this;
    }

    public function getSousTitre(): ?string
    {
        return $this->sousTitre;
    }

    public function setSousTitre(?string $sousTitre): static
    {
        $this->sousTitre = $sousTitre;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }
}
