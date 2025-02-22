<?php

namespace App\Entity;

use App\Repository\RegistrationInvitationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegistrationInvitationRepository::class)]
class RegistrationInvitation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $token = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $expireAt = null;

    #[ORM\Column(length: 255)]
    private ?string $Role = null;

    #[ORM\Column]
    private ?bool $State = false;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?UserCollection $collection = null;

    public function getCollection(): ?UserCollection
    {
        return $this->collection;
    }

    public function __construct(string $email, string $Role, UserCollection $collection)
    {
        $this->email = $email;
        $this->Role = $Role;
        $this->State = false;
        $this->token = bin2hex(random_bytes(32));
        $this->createdAt = new \DateTimeImmutable();
        $this->expireAt = $this->createdAt->modify('+2 days');
        $this->collection = $collection;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getExpireAt(): ?\DateTimeImmutable
    {
        return $this->expireAt;
    }

    public function setExpireAt(\DateTimeImmutable $expireAt): static
    {
        $this->expireAt = $expireAt;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(string $Role): static
    {
        $this->Role = $Role;

        return $this;
    }

    public function isState(): ?bool
    {
        return $this->State;
    }

    public function setState(bool $State): static
    {
        $this->State = $State;

        return $this;
    }

    public function close(): static
    {
        $this->State = true;

        return $this;
    }

}
