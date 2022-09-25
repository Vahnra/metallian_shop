<?php

namespace App\Entity;

use App\Repository\ChaussuresQuantityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChaussuresQuantityRepository::class)]
class ChaussuresQuantity implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'chaussuresQuantities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chaussures $chaussures = null;

    #[ORM\ManyToOne(inversedBy: 'chaussuresQuantities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Color $color = null;

    #[ORM\ManyToOne(inversedBy: 'chaussuresQuantities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Size $size = null;

    #[ORM\Column(length: 255)]
    private ?string $stock = null;

    #[ORM\Column(length: 255)]
    private ?string $sku = null;

    public function getId(): ?int
    {
        return $this->id;
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
