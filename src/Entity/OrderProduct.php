<?php

namespace App\Entity;

use App\Repository\OrderProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderProductRepository::class)]
class OrderProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderProducts')]
    private ?Vetement $vetement = null;

    #[ORM\ManyToOne(inversedBy: 'orderProducts')]
    private ?Accessoires $accessoires = null;

    #[ORM\ManyToOne(inversedBy: 'orderProducts')]
    private ?Chaussures $chaussures = null;

    #[ORM\ManyToOne(inversedBy: 'orderProducts')]
    private ?Media $media = null;

    #[ORM\ManyToOne(inversedBy: 'orderProducts')]
    private ?Bijoux $bijoux = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $size = null;

    #[ORM\ManyToOne(inversedBy: 'orderProducts')]
    private ?VetementMerchandising $vetementMerchandising = null;

    #[ORM\ManyToOne(inversedBy: 'orderProducts')]
    private ?AccessoiresMerchandising $accessoiresMerchandising = null;

    #[ORM\ManyToOne(inversedBy: 'orderProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $orderId = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(length: 255)]
    private ?string $sku = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAccessoires(): ?Accessoires
    {
        return $this->accessoires;
    }

    public function setAccessoires(?Accessoires $accessoires): self
    {
        $this->accessoires = $accessoires;

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

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): self
    {
        $this->media = $media;

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): self
    {
        $this->size = $size;

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

    public function getOrderId(): ?Order
    {
        return $this->orderId;
    }

    public function setOrderId(?Order $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

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
}
