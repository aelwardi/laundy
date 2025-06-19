<?php

namespace App\Entity;

use App\Repository\WashRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WashRepository::class)]
class Wash
{
    #[ORM\Column]
    private ?float $priceKg = null;

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
