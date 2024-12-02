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
    #[ORM\OneToMany(targetEntity: Link::class, mappedBy: 'brands')]
    private Collection $links;

    #[ORM\ManyToOne(inversedBy: 'brands')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BrandCategory $categories = null;

    public function __construct()
    {
        $this->links = new ArrayCollection();
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

    public function getCategories(): ?BrandCategory
    {
        return $this->categories;
    }

    public function setCategories(?BrandCategory $categories): static
    {
        $this->categories = $categories;

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
