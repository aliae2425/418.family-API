<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Il existe déjà un compte avec cette adresse email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

// section identification 
    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private bool $isVerified = false;

    #[ORM\Column]
    private ?\DateTimeImmutable $_createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $_lastActivity = null;

    #[ORM\Column]
    private ?bool $status = true;

    /**
     * @var Collection<int, Adress>
     */
    #[ORM\OneToMany(targetEntity: Adress::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
    private Collection $adresses;

// section user data
    #[ORM\Column(nullable: true)]
    private ?int $coins = null;

    /**
     * @var Collection<int, Cart>
     */
    #[ORM\OneToMany(targetEntity: Cart::class, mappedBy: 'user')]
    private Collection $carts;

    /**
     * @var Collection<int, Family>
     */
    #[ORM\ManyToMany(targetEntity: Family::class)]
    private Collection $familiesCollection;

    /**
     * @var Collection<int, Family>
     */
    #[ORM\OneToMany(targetEntity: Family::class, mappedBy: '_createdBy')]
    private Collection $createdFamilies;

// section entreprise

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Business $relatedBusiness = null;

    #[ORM\OneToOne(mappedBy: 'owner', cascade: ['persist', 'remove'])]
    private ?Business $ownedBusiness = null;

    #[ORM\Column(nullable: true)]
    private ?int $currentCartCount = null;

    public function __toString(): string
    {
        return $this->email;
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function __construct()
    {
        $this->_createdAt = new \DateTimeImmutable();
        $this->adresses = new ArrayCollection();
        
        $this->carts = new ArrayCollection();
        $this->familiesCollection = new ArrayCollection();
        $this->createdFamilies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

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

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getLastActivity(): ?\DateTimeImmutable
    {
        return $this->_lastActivity;
    }

    public function setLastActivity(?\DateTimeImmutable $_lastActivity): static
    {
        $this->_lastActivity = $_lastActivity;

        return $this;
    }

    public function updateActivity(): static
    {
        $this->_lastActivity = new \DateTimeImmutable();

        return $this;
    }

    public function getCoins(): ?int
    {
        return $this->coins;
    }

    public function setCoins(?int $coins): static
    {
        $this->coins = $coins;

        return $this;
    }

    public function addCoins(int $coins): static
    {
        $this->coins += $coins;

        return $this;
    }

    public function removeCoins(int $coins): static
    {
        $this->coins -= $coins;

        return $this;
    }

    /**
     * @return Collection<int, Adress>
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function addAdress(Adress $adress): static
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses->add($adress);
            $adress->setUser($this);
        }

        return $this;
    }

    public function removeAdress(Adress $adress): static
    {
        if ($this->adresses->removeElement($adress)) {
            // set the owning side to null (unless already changed)
            if ($adress->getUser() === $this) {
                $adress->setUser(null);
            }
        }

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
            $cart->setUser($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): static
    {
        if ($this->carts->removeElement($cart)) {
            // set the owning side to null (unless already changed)
            if ($cart->getUser() === $this) {
                $cart->setUser(null);
            }
        }

        return $this;
    }


    public function getAdressCount(): int
    {
        return $this->adresses->count();
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection<int, Family>
     */
    public function getFamilliesCollection(): Collection
    {
        return $this->familiesCollection;
    }

    public function addFamilliesCollection(Family $familly): static
    {
        if (!$this->familiesCollection->contains($familly)) {
            $this->familiesCollection->add($familly);
        }

        return $this;
    }

    public function removeFamilliesCollection(Family $familly): static
    {
        $this->familiesCollection->removeElement($familly);

        return $this;
    }

    /**
     * @return Collection<int, Family>
     */
    public function getCreatedFamillies(): Collection
    {
        return $this->createdFamilies;
    }

    public function addCreatedFamillies(Family $family): static
    {
        if (!$this->createdFamilies->contains($family)) {
            $this->createdFamilies->add($family);
            $family->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedFamillies(Family $family): static
    {
        if ($this->createdFamilies->removeElement($family)) {
            // set the owning side to null (unless already changed)
            if ($family->getCreatedBy() === $this) {
                $family->setCreatedBy(null);
            }
        }

        return $this;
    }

    public function getTotalFamilyCount(): int
    {
        return $this->familiesCollection->count() +  $this->createdFamilies->count();
    }

    public function getFamilyCount(): int
    {
        return $this->familiesCollection->count();
    }

    public function getCreatedFamilyCount(): int
    {
        return $this->createdFamilies->count();
    }

    public function getRelatedBusiness(): ?Business
    {
        return $this->relatedBusiness;
    }

    public function setRelatedBusiness(?Business $business): static
    {
        $this->relatedBusiness = $business;

        return $this;
    }

    public function getOwnedBusiness(): ?Business
    {
        return $this->ownedBusiness;
    }

    public function setOwnedBusiness(Business $ownedBusiness): static
    {
        // set the owning side of the relation if necessary
        if ($ownedBusiness->getOwner() !== $this) {
            $ownedBusiness->setOwner($this);
        }

        $this->ownedBusiness = $ownedBusiness;

        return $this;
    }

    public function getCurrentCartCount(): ?int
    {
        return $this->currentCartCount;
    }

    public function setCurrentCartCount(?int $currentCartCount): static
    {
        $this->currentCartCount = $currentCartCount;

        return $this;
    }
}
