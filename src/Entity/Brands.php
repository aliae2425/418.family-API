<?php

namespace App\Entity;

use App\Repository\BrandsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: BrandsRepository::class)]
#[Vich\Uploadable]
class Brands
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
    private ?string $thumbail = null;

    #[Vich\UploadableField(mapping : "brands", fileNameProperty : "thumbail")]
    #[Assert\Image(mimeTypes: ['image/jpeg', 'image/png', 'image/jpg'])]
    private ?File $File = null;

    /**
     * @var Collection<int, Link>
     */
    #[ORM\OneToMany(targetEntity: Link::class, mappedBy: 'brands', orphanRemoval:true, cascade:["persist"])]
    private Collection $links;

    #[ORM\Column]
    private ?\DateTimeImmutable $_createAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $_updateAt = null;

    /**
     * @var Collection<int, BrandCategory>
     */
    #[ORM\ManyToMany(targetEntity: BrandCategory::class, inversedBy: 'brands')]
    private Collection $categories;

    public function __construct()
    {
        $this->links = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $Name): static
    {
        $this->name = $Name;

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

    public function getThumbail(): ?string
    {
        return $this->thumbail;
    }

    public function setThumbail(string $thumbail): static
    {
        $this->thumbail = $thumbail;

        return $this;
    }

    /**
     * @return Collection<int, Link>
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(Link $link): static
    {
        if (!$this->links->contains($link)) {
            $this->links->add($link);
            $link->setBrands($this);
        }

        return $this;
    }

    public function removeLink(Link $link): static
    {
        if ($this->links->removeElement($link)) {
            // set the owning side to null (unless already changed)
            if ($link->getBrands() === $this) {
                $link->setBrands(null);
            }
        }

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
     * @return Collection<int, BrandCategory>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(BrandCategory $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(BrandCategory $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
