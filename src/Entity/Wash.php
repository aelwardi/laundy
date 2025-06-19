<?php

namespace App\Entity;

use App\Repository\WashRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WashRepository::class)]
class Wash
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?float $priceKg = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPriceKg(): ?float
    {
        return $this->priceKg;
    }

    public function setPriceKg(float $priceKg): static
    {
        $this->priceKg = $priceKg;

        return $this;
    }
}
