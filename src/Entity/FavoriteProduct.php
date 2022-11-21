<?php

namespace App\Entity;

use App\Repository\FavoriteProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteProductRepository::class)]
class FavoriteProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favoriteProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'favoriteProducts')]
    private ?Vetement $vetement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'favoriteProducts')]
    private ?Bijoux $bijoux = null;

    #[ORM\ManyToOne(inversedBy: 'favoriteProducts')]
    private ?Chaussures $chaussures = null;

    #[ORM\ManyToOne(inversedBy: 'favoriteProducts')]
    private ?Accessoires $accessoires = null;

    #[ORM\ManyToOne(inversedBy: 'favoriteProducts')]
    private ?Media $media = null;

    #[ORM\ManyToOne(inversedBy: 'favoriteProducts')]
    private ?VetementMerchandising $vetementMerchandising = null;

    #[ORM\ManyToOne(inversedBy: 'favoriteProducts')]
    private ?AccessoiresMerchandising $accessoiresMerchandising = null;

    #[ORM\ManyToOne(inversedBy: 'favoriteProducts')]
    private ?Products $products = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getVetement(): ?Vetement
    {
        return $this->vetement;
    }

    public function setVetement(?Vetement $vetement): self
    {
        $this->vetement = $vetement;

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

    public function getBijoux(): ?Bijoux
    {
        return $this->bijoux;
    }

    public function setBijoux(?Bijoux $bijoux): self
    {
        $this->bijoux = $bijoux;

        return $this;
    }

    public function getChaussures(): ?Chaussures
    {
        return $this->chaussures;
    }

    public function setChaussures(?Chaussures $chaussures): self
    {
        $this->chaussures = $chaussures;

        return $this;
    }

    public function getAccessoires(): ?Accessoires
    {
        return $this->accessoires;
    }

    public function setAccessoires(?Accessoires $accessoires): self
    {
        $this->accessoires = $accessoires;

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function getVetementMerchandising(): ?VetementMerchandising
    {
        return $this->vetementMerchandising;
    }

    public function setVetementMerchandising(?VetementMerchandising $vetementMerchandising): self
    {
        $this->vetementMerchandising = $vetementMerchandising;

        return $this;
    }

    public function getAccessoiresMerchandising(): ?AccessoiresMerchandising
    {
        return $this->accessoiresMerchandising;
    }

    public function setAccessoiresMerchandising(?AccessoiresMerchandising $accessoiresMerchandising): self
    {
        $this->accessoiresMerchandising = $accessoiresMerchandising;

        return $this;
    }

    public function getProducts(): ?Products
    {
        return $this->products;
    }

    public function setProducts(?Products $products): self
    {
        $this->products = $products;

        return $this;
    }
}
