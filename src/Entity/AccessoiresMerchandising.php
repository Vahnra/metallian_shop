<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ReflectionClass;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AccessoiresMerchandisingRepository;

#[ORM\Entity(repositoryClass: AccessoiresMerchandisingRepository::class)]
#[ORM\Index(name: 'accessoires_merchandising', columns: ['title'], flags: ['fulltext'])]
class AccessoiresMerchandising
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'accessoiresMerchandisings')]
    private ?CategorieMerchandising $categorieMerchandising = null;

    #[ORM\ManyToOne(inversedBy: 'accessoiresMerchandisings')]
    private ?SousCategorieMerchandising $sousCategorieMerchandising = null;

    #[ORM\Column(length: 255)]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletedAt = null;

    #[ORM\ManyToOne(inversedBy: 'accessoiresMerchandisings')]
    private ?Material $material = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $longDescription = null;

    #[ORM\OneToMany(mappedBy: 'accessoiresMerchandising', targetEntity: AccessoiresMerchandisingQuantity::class, orphanRemoval: true)]
    private Collection $accessoiresMerchandisingQuantities;

    #[ORM\Column(length: 255)]
    private ?string $photo2 = null;

    #[ORM\Column(length: 255)]
    private ?string $photo3 = null;

    #[ORM\Column(length: 255)]
    private ?string $photo4 = null;

    #[ORM\Column(length: 255)]
    private ?string $photo5 = null;

    #[ORM\OneToMany(mappedBy: 'accessoiresMerchandising', targetEntity: CartProduct::class)]
    private Collection $cartProducts;

    #[ORM\OneToMany(mappedBy: 'accessoiresMerchandising', targetEntity: FavoriteProduct::class)]
    private Collection $favoriteProducts;

    public function __construct()
    {
        $this->accessoiresMerchandisingQuantities = new ArrayCollection();
        $this->cartProducts = new ArrayCollection();
        $this->favoriteProducts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title; 
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategorieMerchandising(): ?CategorieMerchandising
    {
        return $this->categorieMerchandising;
    }

    public function setCategorieMerchandising(?CategorieMerchandising $categorieMerchandising): self
    {
        $this->categorieMerchandising = $categorieMerchandising;

        return $this;
    }

    public function getSousCategorieMerchandising(): ?SousCategorieMerchandising
    {
        return $this->sousCategorieMerchandising;
    }

    public function setSousCategorieMerchandising(?SousCategorieMerchandising $sousCategorieMerchandising): self
    {
        $this->sousCategorieMerchandising = $sousCategorieMerchandising;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

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

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

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

    public function getClassName()
    {
        return (new ReflectionClass($this))->getShortName();
    }

    /**
     * @return Collection<int, AccessoiresMerchandisingQuantity>
     */
    public function getAccessoiresMerchandisingQuantities(): Collection
    {
        return $this->accessoiresMerchandisingQuantities;
    }

    public function addAccessoiresMerchandisingQuantity(AccessoiresMerchandisingQuantity $accessoiresMerchandisingQuantity): self
    {
        if (!$this->accessoiresMerchandisingQuantities->contains($accessoiresMerchandisingQuantity)) {
            $this->accessoiresMerchandisingQuantities->add($accessoiresMerchandisingQuantity);
            $accessoiresMerchandisingQuantity->setAccessoiresMerchandising($this);
        }

        return $this;
    }

    public function removeAccessoiresMerchandisingQuantity(AccessoiresMerchandisingQuantity $accessoiresMerchandisingQuantity): self
    {
        if ($this->accessoiresMerchandisingQuantities->removeElement($accessoiresMerchandisingQuantity)) {
            // set the owning side to null (unless already changed)
            if ($accessoiresMerchandisingQuantity->getAccessoiresMerchandising() === $this) {
                $accessoiresMerchandisingQuantity->setAccessoiresMerchandising(null);
            }
        }

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

    public function getPhoto5(): ?string
    {
        return $this->photo5;
    }

    public function setPhoto5(string $photo5): self
    {
        $this->photo5 = $photo5;

        return $this;
    }

    /**
     * @return Collection<int, CartProduct>
     */
    public function getCartProducts(): Collection
    {
        return $this->cartProducts;
    }

    public function addCartProduct(CartProduct $cartProduct): self
    {
        if (!$this->cartProducts->contains($cartProduct)) {
            $this->cartProducts->add($cartProduct);
            $cartProduct->setAccessoiresMerchandising($this);
        }

        return $this;
    }

    public function removeCartProduct(CartProduct $cartProduct): self
    {
        if ($this->cartProducts->removeElement($cartProduct)) {
            // set the owning side to null (unless already changed)
            if ($cartProduct->getAccessoiresMerchandising() === $this) {
                $cartProduct->setAccessoiresMerchandising(null);
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
            $favoriteProduct->setAccessoiresMerchandising($this);
        }

        return $this;
    }

    public function removeFavoriteProduct(FavoriteProduct $favoriteProduct): self
    {
        if ($this->favoriteProducts->removeElement($favoriteProduct)) {
            // set the owning side to null (unless already changed)
            if ($favoriteProduct->getAccessoiresMerchandising() === $this) {
                $favoriteProduct->setAccessoiresMerchandising(null);
            }
        }

        return $this;
    }
}
