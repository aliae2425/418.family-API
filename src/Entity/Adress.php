<?php

namespace App\Entity;

use App\Repository\AdressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AdressRepository::class)]
class Adress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'adresses')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "la rue est obligatoire")]
    private ?string $street = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "la ville est obligatoire")]
    private ?string $city = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "le code postal est obligatoire")]
    #[Assert\Length(min: 5, max: 10,
        minMessage: "le code postal doit contenir 5 chiffres",
        maxMessage: "le code postal doit contenir 10 chiffres"
        )
    ]
    private ?int $postalCode = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "le pays est obligatoire")]
    private ?string $country = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $_createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $_updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct(){
        $this->_createdAt = new \DateTimeImmutable();
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(int $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $contry): static
    {
        $this->country = $contry;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->_createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $_createdAt): static
    {
        $this->_createdAt = new \DateTimeImmutable();

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->_updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $_updatedAt): static
    {
        $this->_updatedAt = new \DateTimeImmutable();

        return $this;
    }

    public function __tostring(): string
    {
        return strval($this->id);
    }
}
