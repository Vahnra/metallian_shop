<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
#[ORM\Index(name: 'products', columns: ['title'], flags: ['fulltext'])]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?SousCategorie $sousCategorie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo5 = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Marques $marques = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Material $material = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $longDescription = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Artist $artist = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?MusicType $genre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: ProductsQuantities::class, orphanRemoval: true)]
    private Collection $productsQuantities;

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: FavoriteProduct::class, orphanRemoval: true)]
    private Collection $favoriteProducts;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $releaseDate = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?CategorieMerchandising $categorieMerchandising = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?SousCategorieMerchandising $sousCategorieMerchandising = null;

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: CartProduct::class)]
    private Collection $cartProducts;

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: OrderProduct::class)]
    private Collection $orderProducts;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Images::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $images;

    public function __construct()
    {
        $this->productsQuantities = new ArrayCollection();
        $this->favoriteProducts = new ArrayCollection();
        $this->cartProducts = new ArrayCollection();
        $this->orderProducts = new ArrayCollection();
        $this->images = new ArrayCollection();
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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPhoto2(): ?string
    {
        return $this->photo2;
    }

    public function setPhoto2(?string $photo2): self
    {
        $this->photo2 = $photo2;

        return $this;
    }

    public function getPhoto3(): ?string
    {
        return $this->photo3;
    }

    public function setPhoto3(?string $photo3): self
    {
        $this->photo3 = $photo3;

        return $this;
    }

    public function getPhoto4(): ?string
    {
        return $this->photo4;
    }

    public function setPhoto4(?string $photo4): self
    {
        $this->photo4 = $photo4;

        return $this;
    }

    public function getPhoto5(): ?string
    {
        return $this->photo5;
    }

    public function setPhoto5(?string $photo5): self
    {
        $this->photo5 = $photo5;

        return $this;
    }

    public function getMarques(): ?Marques
    {
        return $this->marques;
    }

    public function setMarques(?Marques $marques): self
    {
        $this->marques = $marques;

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

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): self
    {
        $this->artist = $artist;

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

    public function getGenre(): ?MusicType
    {
        return $this->genre;
    }

    public function setGenre(?MusicType $genre): self
    {
        $this->genre = $genre;

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
            $productsQuantity->setProducts($this);
        }

        return $this;
    }

    public function removeProductsQuantity(ProductsQuantities $productsQuantity): self
    {
        if ($this->productsQuantities->removeElement($productsQuantity)) {
            // set the owning side to null (unless already changed)
            if ($productsQuantity->getProducts() === $this) {
                $productsQuantity->setProducts(null);
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
            $favoriteProduct->setProducts($this);
        }

        return $this;
    }

    public function removeFavoriteProduct(FavoriteProduct $favoriteProduct): self
    {
        if ($this->favoriteProducts->removeElement($favoriteProduct)) {
            // set the owning side to null (unless already changed)
            if ($favoriteProduct->getProducts() === $this) {
                $favoriteProduct->setProducts(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getReleaseDate(): ?string
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?string $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

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
            $cartProduct->setProducts($this);
        }

        return $this;
    }

    public function removeCartProduct(CartProduct $cartProduct): self
    {
        if ($this->cartProducts->removeElement($cartProduct)) {
            // set the owning side to null (unless already changed)
            if ($cartProduct->getProducts() === $this) {
                $cartProduct->setProducts(null);
            }
        }

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
            $orderProduct->setProducts($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProducts->removeElement($orderProduct)) {
            // set the owning side to null (unless already changed)
            if ($orderProduct->getProducts() === $this) {
                $orderProduct->setProducts(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProduct($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

        return $this;
    }
}
