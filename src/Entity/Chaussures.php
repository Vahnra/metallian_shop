<?php

namespace App\Entity;

use ReflectionClass;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ChaussuresRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ChaussuresRepository::class)]
#[ORM\Index(name: 'chaussures', columns: ['title'], flags: ['fulltext'])]
class Chaussures
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\ManyToOne(inversedBy: 'chaussures')]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'chaussures')]
    private ?SousCategorie $sousCategorie = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'chaussures')]
    private ?Material $material = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $longDescription = null;

    #[ORM\Column(length: 255)]
    private ?string $photo2 = null;

    #[ORM\Column(length: 255)]
    private ?string $photo3 = null;

    #[ORM\Column(length: 255)]
    private ?string $photo4 = null;
    #[ORM\OneToMany(mappedBy: 'chaussures', targetEntity: CartProduct::class)]
    private Collection $cartProducts;

    #[ORM\OneToMany(mappedBy: 'chaussures', targetEntity: ChaussuresQuantity::class, orphanRemoval: true)]
    private Collection $chaussuresQuantities;

    #[ORM\OneToMany(mappedBy: 'chaussures', targetEntity: FavoriteProduct::class)]
    private Collection $favoriteProducts;

    #[ORM\Column(length: 255)]
    private ?string $photo5 = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\OneToMany(mappedBy: 'chaussures', targetEntity: OrderProduct::class)]
    private Collection $orderProducts;

    public function __construct()
    {
        $this->cartProducts = new ArrayCollection();
        $this->chaussuresQuantities = new ArrayCollection();
        $this->favoriteProducts = new ArrayCollection();
        $this->orderProducts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title; 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function gettitle(): ?string
    {
        return $this->title;
    }

    public function settitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getSousCategorie(): ?SousCategorie
    {
        return $this->sousCategorie;
    }

    public function setSousCategorie(?SousCategorie $sousCategorie): self
    {
        $this->sousCategorie = $sousCategorie;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getMaterial(): ?Material
    {
        return $this->material;
    }

    public function setMaterial(?Material $material): self
    {
        $this->material = $material;

        return $this;
    }

    public function getLongDescription(): ?string
    {
        return $this->longDescription;
    }

    public function setLongDescription(string $longDescription): self
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    public function getPhoto2(): ?string
    {
        return $this->photo2;
    }

    public function setPhoto2(string $photo2): self
    {
        $this->photo2 = $photo2;
        
        return $this;

    }
    
    public function getCartProducts(): Collection
    {
        return $this->cartProducts;
    }

    public function addCartProduct(CartProduct $cartProduct): self
    {
        if (!$this->cartProducts->contains($cartProduct)) {
            $this->cartProducts->add($cartProduct);
            $cartProduct->setChaussures($this);
        }

        return $this;
    }

    public function getPhoto3(): ?string
    {
        return $this->photo3;
    }

    public function setPhoto3(string $photo3): self
    {
        $this->photo3 = $photo3;

        return $this;
    }

    public function getPhoto4(): ?string
    {
        return $this->photo4;
    }

    public function setPhoto4(string $photo4): self
    {
        $this->photo4 = $photo4;

        return $this;

    }

    public function removeCartProduct(CartProduct $cartProduct): self
    {
        if ($this->cartProducts->removeElement($cartProduct)) {
            // set the owning side to null (unless already changed)
            if ($cartProduct->getChaussures() === $this) {
                $cartProduct->setChaussures(null);
            }
        }

        return $this;
    }

    public function getClassName()
    {
        return (new ReflectionClass($this))->getShortName();
    }

    /**
     * @return Collection<int, ChaussuresQuantity>
     */
    public function getChaussuresQuantities(): Collection
    {
        return $this->chaussuresQuantities;
    }

    public function addChaussuresQuantity(ChaussuresQuantity $chaussuresQuantity): self
    {
        if (!$this->chaussuresQuantities->contains($chaussuresQuantity)) {
            $this->chaussuresQuantities->add($chaussuresQuantity);
            $chaussuresQuantity->setChaussures($this);
        }

        return $this;
    }

    public function removeChaussuresQuantity(ChaussuresQuantity $chaussuresQuantity): self
    {
        if ($this->chaussuresQuantities->removeElement($chaussuresQuantity)) {
            // set the owning side to null (unless already changed)
            if ($chaussuresQuantity->getChaussures() === $this) {
                $chaussuresQuantity->setChaussures(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FavoriteProduct>
     */
    public function getFavoriteProducts(): Collection
    {
        return $this->favoriteProducts;
    }

    public function addFavoriteProduct(FavoriteProduct $favoriteProduct): self
    {
        if (!$this->favoriteProducts->contains($favoriteProduct)) {
            $this->favoriteProducts->add($favoriteProduct);
            $favoriteProduct->setChaussures($this);
        }

        return $this;
    }

    public function removeFavoriteProduct(FavoriteProduct $favoriteProduct): self
    {
        if ($this->favoriteProducts->removeElement($favoriteProduct)) {
            // set the owning side to null (unless already changed)
            if ($favoriteProduct->getChaussures() === $this) {
                $favoriteProduct->setChaussures(null);
            }
        }

        return $this;
    }

    public function getPhoto5(): ?string
    {
        return $this->photo5;
    }

    public function setPhoto5(string $photo5): self
    {
        $this->photo5 = $photo5;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, OrderProduct>
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    public function addOrderProduct(OrderProduct $orderProduct): self
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts->add($orderProduct);
            $orderProduct->setChaussures($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProducts->removeElement($orderProduct)) {
            // set the owning side to null (unless already changed)
            if ($orderProduct->getChaussures() === $this) {
                $orderProduct->setChaussures(null);
            }
        }

        return $this;
    }
}
