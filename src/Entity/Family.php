<?php

namespace App\Entity;

use App\Repository\FamilyRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: FamilyRepository::class)]
#[Vich\Uploadable]
class Family
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $thumbnail = null;

    #[Vich\UploadableField(mapping: 'familyThumbnail', fileNameProperty: 'thumbnail')]
    #[Assert\Image(mimeTypes: ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])]
    private ?File $thumbnailFile = null;

    #[ORM\Column(length: 255)]
    private ?string $revitFamily = null;

    #[Vich\UploadableField(mapping: 'family', fileNameProperty: 'revitFamily')]
    #[Assert\File(mimeTypes: ['application/rfa'])]
    private ?File $revitFamilyFile = null;

    #[ORM\ManyToOne(inversedBy: 'families')]
    #[ORM\JoinColumn(nullable: false)]
    private ?familyCategory $familyCategory = null;

    #[ORM\ManyToOne(inversedBy: 'families')]
    private ?Brands $brand = null;

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

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getRevitFamily(): ?string
    {
        return $this->revitFamily;
    }

    public function setRevitFamily(string $revitFamily): static
    {
        $this->revitFamily = $revitFamily;

        return $this;
    }

    public function getFamilyCategory(): ?familyCategory
    {
        return $this->familyCategory;
    }

    public function setFamilyCategory(?familyCategory $familyCategory): static
    {
        $this->familyCategory = $familyCategory;

        return $this;
    }

    public function getBrand(): ?Brands
    {
        return $this->brand;
    }

    public function setBrand(?Brands $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->thumbnailFile;
    }

    public function setFile(?File $File): static
    {
        $this->thumbnailFile = $File;

        return $this;
    }

    public function getRevitFamilyFile(): ?File
    {
        return $this->revitFamilyFile;
    }

    public function setRevitFamilyFile(?File $revitFamilyFile): static
    {
        $this->revitFamilyFile = $revitFamilyFile;

        return $this;
    }
}
