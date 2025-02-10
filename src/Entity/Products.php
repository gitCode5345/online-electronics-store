<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
#[ORM\Table(name: "products")]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Categories::class)]
    #[ORM\JoinColumn(name: "category_id", referencedColumnName: "id", nullable: false)]
    private ?Categories $category = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $price = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $main_picture = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $pictures = null;

    #[ORM\ManyToOne(targetEntity: Suppliers::class)]
    #[ORM\JoinColumn(name: "supplier_id", referencedColumnName: "id", nullable: false)]
    private ?Suppliers $supplier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): static
    {
        $this->category = $category;

        return $this;
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getmain_picture(): ?string
    {
        return $this->main_picture;
    }

    public function setmain_picture(string $m_picture): static
    {
        $this->main_picture = $m_picture;

        return $this;
    }

    public function getPictures() : ?string
    {
        return $this->pictures;
    }

    public function setPictures(string $pics): static
    {
        $this->pictures = $pics;

        return $this;
    }

    public function getSupplier(): ?Suppliers
    {
        return $this->supplier;
    }

    public function setSupplier(?Suppliers $supplier): static
    {
        $this->supplier = $supplier;

        return $this;
    }
}
