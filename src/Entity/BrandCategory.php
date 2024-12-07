<?php

namespace App\Entity;

use App\Repository\BrandCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File; 
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BrandCategoryRepository::class)]
#[Vich\Uploadable]
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $icon = null;

    #[Vich\UploadableField(mapping : "brandsCategory", fileNameProperty : "icon")]
    #[Assert\Image(mimeTypes: ['image/svg+xml'])]
    private ?File $File = null;

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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->File;
    }

    public function setFile(?File $File): static
    {
        $this->File = $File;

        return $this;
    }
}
