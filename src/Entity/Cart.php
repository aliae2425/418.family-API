<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $value = null;

    #[ORM\ManyToOne(inversedBy: 'carts')]
    private ?User $user = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $_createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $_validationAt = null;

    /**
     * @var Collection<int, Family>
     */
    #[ORM\ManyToMany(targetEntity: Family::class, inversedBy: 'carts')]
    private Collection $famillies;

    #[ORM\Column]
    private ?bool $validate = false;

    public function __construct()
    {
        $this->_createdAt = new \DateTimeImmutable();
        $this->famillies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function caculValue(): static
    {
        $value = 0;
        foreach($this->famillies as $familly) {
            $value += $familly->getPrice();
        }
        return $this;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
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

    public function getValidationAt(): ?\DateTimeImmutable
    {
        return $this->_validationAt;
    }

    public function setValidationAt(\DateTimeImmutable $_validationAt): static
    {
        $this->_validationAt = new \DateTimeImmutable();

        return $this;
    }

    /**
     * @return Collection<int, Family>
     */
    public function getFamillies(): Collection
    {
        return $this->famillies;
    }

    public function addFamilly(Family $familly): static
    {
        if (!$this->famillies->contains($familly)) {
            $this->famillies->add($familly);
        }

        return $this;
    }

    public function removeFamilly(Family $familly): static
    {
        $this->famillies->removeElement($familly);

        return $this;
    }

    public function clearFamillies(): static
    {
        $this->famillies->clear();

        return $this;
    }

    public function getFamillyCount(): int
    {
        return $this->famillies->count();
    }

    public function isValidate(): ?bool
    {
        return $this->validate;
    }

    public function setValidate(bool $validate): static
    {
        $this->validate = $validate;

        return $this;
    }
}
