<?php

namespace App\Entity;

use App\Repository\FamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FamilyRepository::class)]
#[Vich\Uploadable]
class Family
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['family:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['family:read'])]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $_createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $_updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['family:read'])]
    private ?string $thumbnail = null;

    #[Vich\UploadableField(mapping: 'familyThumbnail', fileNameProperty: 'thumbnail')]
    #[Assert\Image(mimeTypes: ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])]
    private ?File $thumbnailFile = null;

    #[ORM\Column(length: 255, )]
    private ?string $revitFamily = null;

    #[Vich\UploadableField(mapping: 'family', fileNameProperty: 'revitFamily')]
    private ?File $revitFamilyFile = null;

    #[ORM\ManyToOne(inversedBy: 'families')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FamilyCategory $familyCategory = null;

    #[ORM\ManyToOne(inversedBy: 'families')]
    private ?Brands $brand = null;

    /**
     * @var Collection<int, Cart>
     */
    #[ORM\ManyToMany(targetEntity: Cart::class, mappedBy: 'famillies')]
    private Collection $carts;

    #[ORM\Column( nullable: true)]
    #[Groups(['family:read'])]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'families')]
    private ?User $_createdBy = null;

    /**
     * @var Collection<int, UserCollection>
     */
    #[ORM\ManyToMany(targetEntity: UserCollection::class, mappedBy: 'famillies')]
    private Collection $userCollections;

    public function __construct()
    {
        $this->carts = new ArrayCollection();
        $this->userCollections = new ArrayCollection();
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

    public function getThumbnailFile(): ?File
    {
        return $this->thumbnailFile;
    }

    public function setThumbnailFile(?File $File): static
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

    /**
     * @return Collection<int, Cart>
     */
    public function getCarts(): Collection
    {
        return $this->carts;
    }

    public function addCart(Cart $cart): static
    {
        if (!$this->carts->contains($cart)) {
            $this->carts->add($cart);
            $cart->addFamilly($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): static
    {
        if ($this->carts->removeElement($cart)) {
            $cart->removeFamilly($this);
        }

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->_createdBy;
    }

    public function setCreatedBy(?User $_createdBy): static
    {
        $this->_createdBy = $_createdBy;

        return $this;
    }

    /**
     * @return Collection<int, UserCollection>
     */
    public function getUserCollections(): Collection
    {
        return $this->userCollections;
    }

    public function addUserCollection(UserCollection $userCollection): static
    {
        if (!$this->userCollections->contains($userCollection)) {
            $this->userCollections->add($userCollection);
            $userCollection->addFamilly($this);
        }

        return $this;
    }

    public function removeUserCollection(UserCollection $userCollection): static
    {
        if ($this->userCollections->removeElement($userCollection)) {
            $userCollection->removeFamilly($this);
        }

        return $this;
    }
}
