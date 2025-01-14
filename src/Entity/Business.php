<?php

namespace App\Entity;

use App\Repository\BusinessRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BusinessRepository::class)]
class Business
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column]
    private ?\DateTimeImmutable $_createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $_updatedAt = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'business')]
    private Collection $users;

    #[ORM\OneToOne(inversedBy: 'ownedBusiness', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\Column]
    private ?bool $activeStatus = null;

    /**
     * @var Collection<int, RegistrationInvitation>
     */
    #[ORM\OneToMany(targetEntity: RegistrationInvitation::class, mappedBy: 'business')]
    private Collection $registrationInvitations;

    public function __construct()
    {
        $this->_createdAt = new \DateTimeImmutable();
        $this->_updatedAt = new \DateTimeImmutable();  
        $this->users = new ArrayCollection();
        $this->registrationInvitations = new ArrayCollection();
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

    public function Update(): static
    {
        $this->_updatedAt = new \DateTimeImmutable();

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setBusiness($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getBusiness() === $this) {
                $user->setBusiness(null);
            }
        }

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

    public function isActiveStatus(): ?bool
    {
        return $this->activeStatus;
    }

    public function setActiveStatus(bool $activeStatus): static
    {
        $this->activeStatus = $activeStatus;

        return $this;
    }

    /**
     * @return Collection<int, RegistrationInvitation>
     */
    public function getRegistrationInvitations(): Collection
    {
        return $this->registrationInvitations;
    }

    public function addRegistrationInvitation(RegistrationInvitation $registrationInvitation): static
    {
        if (!$this->registrationInvitations->contains($registrationInvitation)) {
            $this->registrationInvitations->add($registrationInvitation);
            $registrationInvitation->setBusiness($this);
        }

        return $this;
    }

    public function removeRegistrationInvitation(RegistrationInvitation $registrationInvitation): static
    {
        if ($this->registrationInvitations->removeElement($registrationInvitation)) {
            // set the owning side to null (unless already changed)
            if ($registrationInvitation->getBusiness() === $this) {
                $registrationInvitation->setBusiness(null);
            }
        }

        return $this;
    }
}
