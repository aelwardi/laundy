<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fullName = null;

    #[ORM\Column(length: 255)]
    private ?string $fullAddress = null;

    #[ORM\Column]
    private ?\DateTime $collectedAt = null;

    #[ORM\Column]
    private ?\DateTime $livredAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $instructions = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getFullAddress(): ?string
    {
        return $this->fullAddress;
    }

    public function setFullAddress(string $fullAddress): static
    {
        $this->fullAddress = $fullAddress;

        return $this;
    }

    public function getCollectedAt(): ?\DateTime
    {
        return $this->collectedAt;
    }

    public function setCollectedAt(\DateTime $collectedAt): static
    {
        $this->collectedAt = $collectedAt;

        return $this;
    }

    public function getLivredAt(): ?\DateTime
    {
        return $this->livredAt;
    }

    public function setLivredAt(\DateTime $livredAt): static
    {
        $this->livredAt = $livredAt;

        return $this;
    }

    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    public function setInstructions(string $instructions): static
    {
        $this->instructions = $instructions;

        return $this;
    }
}
