<?php

namespace App\Entity;

use App\Enum\statusOrderEnum;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $priceTotal = null;

    #[ORM\Column(enumType: statusOrderEnum::class)]
    private ?statusOrderEnum $status = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $usere = null;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'ordere')]
    private Collection $items;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'ordere')]
    private Collection $comments;

    #[ORM\OneToOne(mappedBy: 'ordere', cascade: ['persist', 'remove'])]
    private ?Livraison $livraison = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriceTotal(): ?float
    {
        return $this->priceTotal;
    }

    public function setPriceTotal(float $priceTotal): static
    {
        $this->priceTotal = $priceTotal;

        return $this;
    }

    public function getStatus(): ?statusOrderEnum
    {
        return $this->status;
    }

    public function setStatus(statusOrderEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUsere(): ?User
    {
        return $this->usere;
    }

    public function setUsere(?User $usere): static
    {
        $this->usere = $usere;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setOrdere($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            if ($item->getOrdere() === $this) {
                $item->setOrdere(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setOrdere($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            if ($comment->getOrdere() === $this) {
                $comment->setOrdere(null);
            }
        }

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): static
    {
        if ($livraison === null && $this->livraison !== null) {
            $this->livraison->setOrdere(null);
        }

        if ($livraison !== null && $livraison->getOrdere() !== $this) {
            $livraison->setOrdere($this);
        }

        $this->livraison = $livraison;

        return $this;
    }

    public function __toString(): string
    {
        return 'Commande #' . $this->id . ' (' . number_format($this->priceTotal ?? 0, 2) . ' €)';
    }
}
