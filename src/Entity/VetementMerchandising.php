<?php

namespace App\Entity;

use App\Repository\VetementMerchandisingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VetementMerchandisingRepository::class)]
class VetementMerchandising
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

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletedAt = null;

    #[ORM\ManyToOne(inversedBy: 'vetementMerchandisings')]
    private ?CategorieMerchandising $categorieMerchandising = null;

    #[ORM\ManyToOne(inversedBy: 'vetementMerchandisings')]
    private ?SousCategorieMerchandising $sousCategorieMerchandising = null;

    #[ORM\ManyToOne(inversedBy: 'vetementMerchandisings')]
    private ?Marques $marques = null;

    #[ORM\Column(length: 255)]
    private ?string $price = null;

    #[ORM\ManyToOne(inversedBy: 'vetementMerchandisings')]
    private ?Color $color = null;

    #[ORM\ManyToOne(inversedBy: 'vetementMerchandisings')]
    private ?Size $size = null;

    #[ORM\ManyToOne(inversedBy: 'vetementMerchandisings')]
    private ?Material $material = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $longDescription = null;

    #[ORM\Column(length: 255)]
    private ?string $stock = null;

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

    public function getMarques(): ?Marques
    {
        return $this->marques;
    }

    public function setMarques(?Marques $marques): self
    {
        $this->marques = $marques;

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

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getSize(): ?Size
    {
        return $this->size;
    }

    public function setSize(?Size $size): self
    {
        $this->size = $size;

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

    public function getStock(): ?string
    {
        return $this->stock;
    }

    public function setStock(string $stock): self
    {
        $this->stock = $stock;

        return $this;
    }
}
