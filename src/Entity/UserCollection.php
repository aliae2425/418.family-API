<?php

namespace App\Entity;

use App\Repository\UserCollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserCollectionRepository::class)]
class UserCollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Coins = null;

    /**
     * @var Collection<int, user>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'userCollection')]
    private Collection $user;

    /**
     * @var Collection<int, Family>
     */
    #[ORM\ManyToMany(targetEntity: Family::class, inversedBy: 'userCollections')]
    private Collection $famillies;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->famillies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoins(): ?int
    {
        return $this->Coins;
    }

    public function setCoins(int $Coins): static
    {
        $this->Coins = $Coins;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setUserCollection($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getUserCollection() === $this) {
                $user->setUserCollection(null);
            }
        }

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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}
