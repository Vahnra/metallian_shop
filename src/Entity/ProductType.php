<?php

namespace App\Entity;

use App\Repository\ProductTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductTypeRepository::class)]
class ProductType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'productType', targetEntity: Size::class)]
    private Collection $size;

    #[ORM\OneToMany(mappedBy: 'productType', targetEntity: Color::class)]
    private Collection $color;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'productType')]
    private Collection $products;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    public function __construct()
    {
        $this->size = new ArrayCollection();
        $this->color = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title; 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Size>
     */
    public function getSize(): Collection
    {
        return $this->size;
    }

    public function addSize(Size $size): self
    {
        if (!$this->size->contains($size)) {
            $this->size->add($size);
            $size->setProductType($this);
        }

        return $this;
    }

    public function removeSize(Size $size): self
    {
        if ($this->size->removeElement($size)) {
            // set the owning side to null (unless already changed)
            if ($size->getProductType() === $this) {
                $size->setProductType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Color>
     */
    public function getColor(): Collection
    {
        return $this->color;
    }

    public function addColor(Color $color): self
    {
        if (!$this->color->contains($color)) {
            $this->color->add($color);
            $color->setProductType($this);
        }

        return $this;
    }

    public function removeColor(Color $color): self
    {
        if ($this->color->removeElement($color)) {
            // set the owning side to null (unless already changed)
            if ($color->getProductType() === $this) {
                $color->setProductType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->addProductType($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeProductType($this);
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
