<?php

namespace App\Entity;

use App\Repository\SizeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SizeRepository::class)]
class Size implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $size = null;

    #[ORM\OneToMany(mappedBy: 'size', targetEntity: ProductsQuantities::class)]
    private Collection $productsQuantities;

    public function __construct()
    {
        $this->productsQuantities = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->size; 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
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
            $productsQuantity->setSize($this);
        }

        return $this;
    }

    public function removeProductsQuantity(ProductsQuantities $productsQuantity): self
    {
        if ($this->productsQuantities->removeElement($productsQuantity)) {
            // set the owning side to null (unless already changed)
            if ($productsQuantity->getSize() === $this) {
                $productsQuantity->setSize(null);
            }
        }

        return $this;
    }
}
