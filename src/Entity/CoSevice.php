<?php

namespace App\Entity;

use App\Repository\CoSeviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoSeviceRepository::class)]
class CoSevice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'coSevices')]
    private ?Service $service = null;

    /**
     * @var Collection<int, SubService>
     */
    #[ORM\OneToMany(targetEntity: SubService::class, mappedBy: 'coservice', cascade: ['persist', 'remove'])]
    private Collection $subServices;

    public function __construct()
    {
        $this->subServices = new ArrayCollection();
    }

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

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return Collection<int, SubService>
     */
    public function getSubServices(): Collection
    {
        return $this->subServices;
    }

    public function addSubService(SubService $subService): static
    {
        if (!$this->subServices->contains($subService)) {
            $this->subServices->add($subService);
            $subService->setCoservice($this);
        }

        return $this;
    }

    public function removeSubService(SubService $subService): static
    {
        if ($this->subServices->removeElement($subService)) {
            if ($subService->getCoservice() === $this) {
                $subService->setCoservice(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->title ?? 'CoSevice';
    }
}
