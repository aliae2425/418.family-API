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
    #[ORM\OneToMany(targetEntity: user::class, mappedBy: 'userCollection')]
    private Collection $user;

    /**
     * @var Collection<int, family>
     */
    #[ORM\ManyToMany(targetEntity: family::class, inversedBy: 'userCollections')]
    private Collection $famillies;

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
     * @return Collection<int, user>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(user $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setUserCollection($this);
        }

        return $this;
    }

    public function removeUser(user $user): static
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
     * @return Collection<int, family>
     */
    public function getFamillies(): Collection
    {
        return $this->famillies;
    }

    public function addFamilly(family $familly): static
    {
        if (!$this->famillies->contains($familly)) {
            $this->famillies->add($familly);
        }

        return $this;
    }

    public function removeFamilly(family $familly): static
    {
        $this->famillies->removeElement($familly);

        return $this;
    }
}
