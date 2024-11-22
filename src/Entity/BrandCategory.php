<?php

namespace App\Entity;

use App\Repository\BrandCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrandCategoryRepository::class)]
class BrandCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Fabricant>
     */
    #[ORM\OneToMany(targetEntity: Fabricant::class, mappedBy: 'category')]
    private Collection $fabricants;

    public function __construct()
    {
        $this->fabricants = new ArrayCollection();
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

    /**
     * @return Collection<int, Fabricant>
     */
    public function getFabricants(): Collection
    {
        return $this->fabricants;
    }

    public function addFabricant(Fabricant $fabricant): static
    {
        if (!$this->fabricants->contains($fabricant)) {
            $this->fabricants->add($fabricant);
            $fabricant->setCategory($this);
        }

        return $this;
    }

    public function removeFabricant(Fabricant $fabricant): static
    {
        if ($this->fabricants->removeElement($fabricant)) {
            // set the owning side to null (unless already changed)
            if ($fabricant->getCategory() === $this) {
                $fabricant->setCategory(null);
            }
        }

        return $this;
    }
}
