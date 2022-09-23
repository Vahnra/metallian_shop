<?php

namespace App\Entity;

use App\Repository\BijouxQuantityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BijouxQuantityRepository::class)]
class BijouxQuantity implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bijouxQuantities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bijoux $bijoux = null;

    #[ORM\ManyToOne(inversedBy: 'bijouxQuantities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Color $color = null;

    #[ORM\Column(length: 255)]
    private ?string $stock = null;

    #[ORM\Column(length: 255)]
    private ?string $sku = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

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

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}
