<?php

namespace App\Entity;

use App\Repository\SubServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubServiceRepository::class)]
class SubService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $priceArticle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPriceArticle(): ?float
    {
        return $this->priceArticle;
    }

    public function setPriceArticle(float $priceArticle): static
    {
        $this->priceArticle = $priceArticle;

        return $this;
    }
}
