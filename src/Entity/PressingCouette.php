<?php

namespace App\Entity;

use App\Repository\PressingCouetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PressingCouetteRepository::class)]
class PressingCouette extends Service
{
    /**
     * @var Collection<int, SubService>
     */
    #[ORM\OneToMany(targetEntity: SubService::class, mappedBy: 'pressingCouette')]
    private Collection $subServices;

    /**
     * @var Collection<int, DetailsService>
     */
    #[ORM\OneToMany(targetEntity: DetailsService::class, mappedBy: 'pressingCouette')]
    private Collection $detailsServices;

    public function __construct()
    {
        $this->subServices = new ArrayCollection();
        $this->detailsServices = new ArrayCollection();
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
            $subService->setPressingCouette($this);
        }

        return $this;
    }

    public function removeSubService(SubService $subService): static
    {
        if ($this->subServices->removeElement($subService)) {
            // set the owning side to null (unless already changed)
            if ($subService->getPressingCouette() === $this) {
                $subService->setPressingCouette(null);
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
            $detailsService->setPressingCouette($this);
        }

        return $this;
    }

    public function removeDetailsService(DetailsService $detailsService): static
    {
        if ($this->detailsServices->removeElement($detailsService)) {
            // set the owning side to null (unless already changed)
            if ($detailsService->getPressingCouette() === $this) {
                $detailsService->setPressingCouette(null);
            }
        }

        return $this;
    }
}
