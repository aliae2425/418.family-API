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

    #[ORM\Column]
    private ?\DateTimeImmutable $_createAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $_updateAt = null;

    /**
     * @var Collection<int, Brands>
     */
    #[ORM\ManyToMany(targetEntity: Brands::class, mappedBy: 'categories')]
    private Collection $brands;

    public function __construct()
    {
        $this->brands = new ArrayCollection();
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


    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->_createAt;
    }

    public function setCreateAt(\DateTimeImmutable $_createAt): static
    {
        $this->_createAt = $_createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->_updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $_updateAt): static
    {
        $this->_updateAt = $_updateAt;

        return $this;
    }

    /**
     * @return Collection<int, Brands>
     */
    public function getBrands(): Collection
    {
        return $this->brands;
    }

    public function addBrand(Brands $brand): static
    {
        if (!$this->brands->contains($brand)) {
            $this->brands->add($brand);
            $brand->addCategory($this);
        }

        return $this;
    }

    public function removeBrand(Brands $brand): static
    {
        if ($this->brands->removeElement($brand)) {
            $brand->removeCategory($this);
        }

        return $this;
    }
}
