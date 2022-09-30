<?php

namespace App\Entity;

use ReflectionClass;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MediaRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[ORM\Index(name: 'media', columns: ['title'], flags: ['fulltext'])]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $price = null;

    #[ORM\ManyToOne(inversedBy: 'media')]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'media')]
    private ?SousCategorie $sousCategorie = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $longDescription = null;

    #[ORM\ManyToOne(inversedBy: 'media')]
    private ?Artist $artist = null;

    #[ORM\ManyToOne(inversedBy: 'media')]
    private ?MusicType $genre = null;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: ReviewMedia::class)]
    private Collection $reviewMedia;

    #[ORM\Column(length: 255)]
    private ?string $releaseDate = null;

    #[ORM\Column(length: 255)]
    private ?string $photo1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo3 = null;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: CartProduct::class)]
    private Collection $cartProducts;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo4 = null;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: FavoriteProduct::class)]
    private Collection $favoriteProducts;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: MediaQuantity::class, orphanRemoval: true)]
    private Collection $mediaQuantities;

    public function __construct()
    {
        $this->reviewMedia = new ArrayCollection();
        $this->cartProducts = new ArrayCollection();
        $this->favoriteProducts = new ArrayCollection();
        $this->mediaQuantities = new ArrayCollection();
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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

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

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

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

    public function getGenre(): ?MusicType
    {
        return $this->genre;
    }

    public function setGenre(?MusicType $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return Collection<int, ReviewMedia>
     */
    public function getReviewMedia(): Collection
    {
        return $this->reviewMedia;
    }

    public function addReviewMedium(ReviewMedia $reviewMedium): self
    {
        if (!$this->reviewMedia->contains($reviewMedium)) {
            $this->reviewMedia->add($reviewMedium);
            $reviewMedium->setMedia($this);
        }

        return $this;
    }

    public function removeReviewMedium(ReviewMedia $reviewMedium): self
    {
        if ($this->reviewMedia->removeElement($reviewMedium)) {
            // set the owning side to null (unless already changed)
            if ($reviewMedium->getMedia() === $this) {
                $reviewMedium->setMedia(null);
            }
        }

        return $this;
    }

    public function getReleaseDate(): ?string
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(string $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getPhoto1(): ?string
    {
        return $this->photo1;
    }

    public function setPhoto1(string $photo1): self
    {
        $this->photo1 = $photo1;

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
            $cartProduct->setMedia($this);
        }

        return $this;
    }

    public function removeCartProduct(CartProduct $cartProduct): self
    {
        if ($this->cartProducts->removeElement($cartProduct)) {
            // set the owning side to null (unless already changed)
            if ($cartProduct->getMedia() === $this) {
                $cartProduct->setMedia(null);
            }
        }

        return $this;
    }

    public function getClassName()
    {
        return (new ReflectionClass($this))->getShortName();
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
            $favoriteProduct->setMedia($this);
        }

        return $this;
    }

    public function removeFavoriteProduct(FavoriteProduct $favoriteProduct): self
    {
        if ($this->favoriteProducts->removeElement($favoriteProduct)) {
            // set the owning side to null (unless already changed)
            if ($favoriteProduct->getMedia() === $this) {
                $favoriteProduct->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MediaQuantity>
     */
    public function getMediaQuantities(): Collection
    {
        return $this->mediaQuantities;
    }

    public function addMediaQuantity(MediaQuantity $mediaQuantity): self
    {
        if (!$this->mediaQuantities->contains($mediaQuantity)) {
            $this->mediaQuantities->add($mediaQuantity);
            $mediaQuantity->setMedia($this);
        }

        return $this;
    }

    public function removeMediaQuantity(MediaQuantity $mediaQuantity): self
    {
        if ($this->mediaQuantities->removeElement($mediaQuantity)) {
            // set the owning side to null (unless already changed)
            if ($mediaQuantity->getMedia() === $this) {
                $mediaQuantity->setMedia(null);
            }
        }

        return $this;
    }

    
}
