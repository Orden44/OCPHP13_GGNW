<?php

namespace App\Entity;

use App\Repository\CustomerOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerOrderRepository::class)]
class CustomerOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $orderDate = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $totalPrice = null;

    #[ORM\ManyToOne(inversedBy: 'customerOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $byUser = null;

    /**
     * @var Collection<int, CartItems>
     */
    #[ORM\OneToMany(targetEntity: CartItems::class, mappedBy: 'customerOrder')]
    private Collection $cartItems;

    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): static
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getTotalPrice(): ?string
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(string $totalPrice): static
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getByUser(): ?User
    {
        return $this->byUser;
    }

    public function setByUser(?User $byUser): static
    {
        $this->byUser = $byUser;

        return $this;
    }

    /**
     * @return Collection<int, CartItems>
     */
    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }

    public function addCartItem(CartItems $cartItem): static
    {
        if (!$this->cartItems->contains($cartItem)) {
            $this->cartItems->add($cartItem);
            $cartItem->setCustomerOrder($this);
        }

        return $this;
    }

    public function removeCartItem(CartItems $cartItem): static
    {
        if ($this->cartItems->removeElement($cartItem)) {
            // set the owning side to null (unless already changed)
            if ($cartItem->getCustomerOrder() === $this) {
                $cartItem->setCustomerOrder(null);
            }
        }

        return $this;
    }
}
