<?php

namespace App\Entity;

use App\Repository\OrderItemsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderItemsRepository::class)]
class OrdersItems
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Связь с заказом
    #[ORM\ManyToOne(targetEntity: "App\Entity\Orders", inversedBy: "items")]
    #[ORM\JoinColumn(name: "order_id", referencedColumnName: "id", onDelete: "CASCADE")]
    private ?Orders $order = null;

    // Связь с продуктом
    #[ORM\ManyToOne(targetEntity: "App\Entity\Products", inversedBy: "orderItems")]
    #[ORM\JoinColumn(name: "product_id", referencedColumnName: "id", onDelete: "CASCADE")]
    private ?Products $product = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getOrder(): ?Orders
    {
        return $this->order;
    }

    public function setOrder(?Orders $order): static
    {
        $this->order = $order;

        return $this;
    }

    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }
}
