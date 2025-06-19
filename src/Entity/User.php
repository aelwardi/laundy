<?php

namespace App\Entity;

use App\Enum\typeUserEnum;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 50)]
    private ?string $phone = null;

    #[ORM\Column(enumType: typeUserEnum::class)]
    private ?typeUserEnum $type = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Laundry $laundry = null;

    /**
     * @var Collection<int, Address>
     */
    #[ORM\ManyToMany(targetEntity: Address::class, inversedBy: 'users')]
    private Collection $addresse;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'usere')]
    private Collection $orders;

    /**
     * @var Collection<int, SupportTicket>
     */
    #[ORM\OneToMany(targetEntity: SupportTicket::class, mappedBy: 'usere')]
    private Collection $supportTickets;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'usere')]
    private Collection $messages;

    public function __construct()
    {
        $this->addresse = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->supportTickets = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

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

    public function getType(): ?typeUserEnum
    {
        return $this->type;
    }

    public function setType(typeUserEnum $type): static
    {
        $this->type = $type;

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

    /**
     * @return Collection<int, Address>
     */
    public function getAddresse(): Collection
    {
        return $this->addresse;
    }

    public function addAddresse(Address $addresse): static
    {
        if (!$this->addresse->contains($addresse)) {
            $this->addresse->add($addresse);
        }

        return $this;
    }

    public function removeAddresse(Address $addresse): static
    {
        $this->addresse->removeElement($addresse);

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setUsere($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUsere() === $this) {
                $order->setUsere(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SupportTicket>
     */
    public function getSupportTickets(): Collection
    {
        return $this->supportTickets;
    }

    public function addSupportTicket(SupportTicket $supportTicket): static
    {
        if (!$this->supportTickets->contains($supportTicket)) {
            $this->supportTickets->add($supportTicket);
            $supportTicket->setUsere($this);
        }

        return $this;
    }

    public function removeSupportTicket(SupportTicket $supportTicket): static
    {
        if ($this->supportTickets->removeElement($supportTicket)) {
            // set the owning side to null (unless already changed)
            if ($supportTicket->getUsere() === $this) {
                $supportTicket->setUsere(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setUsere($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUsere() === $this) {
                $message->setUsere(null);
            }
        }

        return $this;
    }
}
