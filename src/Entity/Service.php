<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[ORM\DiscriminatorColumn(name: 'dtype', type: 'string')]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorMap(['pressing' => Pressing::class, 'ameublement' => Ameublement::class, 'wash' => Wash::class])]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    private ?Laundry $laundry = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $icon = null;

    /**
     * @var Collection<int, CoSevice>
     */
    #[ORM\OneToMany(targetEntity: CoSevice::class, mappedBy: 'service', cascade: ['persist', 'remove'])]
    private Collection $coSevices;

    /**
     * @var Collection<int, DetailsService>
     */
    #[ORM\OneToMany(targetEntity: DetailsService::class, mappedBy: 'service', cascade: ['persist', 'remove'])]
    private Collection $detailsServices;

    public function __construct()
    {
        $this->coSevices = new ArrayCollection();
        $this->detailsServices = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLaundry(): ?Laundry
    {
        return $this->laundry;
    }

    public function setLaundry(?Laundry $laundry): static
    {
        $this->laundry = $laundry;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return Collection<int, CoSevice>
     */
    public function getCoSevices(): Collection
    {
        return $this->coSevices;
    }

    public function addCoSevice(CoSevice $coSevice): static
    {
        if (!$this->coSevices->contains($coSevice)) {
            $this->coSevices->add($coSevice);
            $coSevice->setService($this);
        }

        return $this;
    }

    public function removeCoSevice(CoSevice $coSevice): static
    {
        if ($this->coSevices->removeElement($coSevice)) {
            if ($coSevice->getService() === $this) {
                $coSevice->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DetailsService>
     */
    public function getDetailsServices(): Collection
    {
        return $this->detailsServices;
    }

    public function addDetailsService(DetailsService $detailsService): static
    {
        if (!$this->detailsServices->contains($detailsService)) {
            $this->detailsServices->add($detailsService);
            $detailsService->setService($this);
        }

        return $this;
    }

    public function removeDetailsService(DetailsService $detailsService): static
    {
        if ($this->detailsServices->removeElement($detailsService)) {
            if ($detailsService->getService() === $this) {
                $detailsService->setService(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? 'Service';
    }
}
