<?php

namespace App\Entity;

use App\Repository\LaundryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LaundryRepository::class)]
class Laundry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 50)]
    private ?string $phone = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    /**
     * @var Collection<int, Section>
     */
    #[ORM\OneToMany(targetEntity: Section::class, mappedBy: 'laundry')]
    private Collection $sections;

    /**
     * @var Collection<int, SocialMedia>
     */
    #[ORM\OneToMany(targetEntity: SocialMedia::class, mappedBy: 'laundry')]
    private Collection $socialMedia;

    /**
     * @var Collection<int, HowWorks>
     */
    #[ORM\OneToMany(targetEntity: HowWorks::class, mappedBy: 'laundry')]
    private Collection $howWorks;

    /**
     * @var Collection<int, Service>
     */
    #[ORM\OneToMany(targetEntity: Service::class, mappedBy: 'laundry')]
    private Collection $services;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'laundry')]
    private Collection $users;

    public function __construct()
    {
        $this->sections = new ArrayCollection();
        $this->socialMedia = new ArrayCollection();
        $this->howWorks = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Section>
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): static
    {
        if (!$this->sections->contains($section)) {
            $this->sections->add($section);
            $section->setLaundry($this);
        }

        return $this;
    }

    public function removeSection(Section $section): static
    {
        if ($this->sections->removeElement($section)) {
            if ($section->getLaundry() === $this) {
                $section->setLaundry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SocialMedia>
     */
    public function getSocialMedia(): Collection
    {
        return $this->socialMedia;
    }

    public function addSocialMedium(SocialMedia $socialMedium): static
    {
        if (!$this->socialMedia->contains($socialMedium)) {
            $this->socialMedia->add($socialMedium);
            $socialMedium->setLaundry($this);
        }

        return $this;
    }

    public function removeSocialMedium(SocialMedia $socialMedium): static
    {
        if ($this->socialMedia->removeElement($socialMedium)) {
            if ($socialMedium->getLaundry() === $this) {
                $socialMedium->setLaundry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HowWorks>
     */
    public function getHowWorks(): Collection
    {
        return $this->howWorks;
    }

    public function addHowWork(HowWorks $howWork): static
    {
        if (!$this->howWorks->contains($howWork)) {
            $this->howWorks->add($howWork);
            $howWork->setLaundry($this);
        }

        return $this;
    }

    public function removeHowWork(HowWorks $howWork): static
    {
        if ($this->howWorks->removeElement($howWork)) {
            if ($howWork->getLaundry() === $this) {
                $howWork->setLaundry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setLaundry($this);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->services->removeElement($service)) {
            if ($service->getLaundry() === $this) {
                $service->setLaundry(null);
            }
        }

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
            $user->setLaundry($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            if ($user->getLaundry() === $this) {
                $user->setLaundry(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? 'Laverie sans nom';
    }
}
