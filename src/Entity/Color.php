<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ColorRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ColorRepository::class)]
class Color implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $color = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\OneToMany(mappedBy: 'color', targetEntity: ProductsQuantities::class)]
    private Collection $productsQuantities;

    public function __construct()
    {
        $this->productsQuantities = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->color; 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, ProductsQuantities>
     */
    public function getProductsQuantities(): Collection
    {
        return $this->productsQuantities;
    }

    public function addProductsQuantity(ProductsQuantities $productsQuantity): self
    {
        if (!$this->productsQuantities->contains($productsQuantity)) {
            $this->productsQuantities->add($productsQuantity);
            $productsQuantity->setColor($this);
        }

        return $this;
    }

    public function removeProductsQuantity(ProductsQuantities $productsQuantity): self
    {
        if ($this->productsQuantities->removeElement($productsQuantity)) {
            // set the owning side to null (unless already changed)
            if ($productsQuantity->getColor() === $this) {
                $productsQuantity->setColor(null);
            }
        }

        return $this;
    }
}
