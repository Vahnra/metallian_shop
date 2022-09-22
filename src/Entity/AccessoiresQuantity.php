<?php

namespace App\Entity;

use App\Repository\AccessoiresQuantityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccessoiresQuantityRepository::class)]
class AccessoiresQuantity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'accessoiresQuantities')]
    private ?Accessoires $accessoires = null;

    #[ORM\ManyToOne(inversedBy: 'accessoiresQuantities')]
    private ?Color $color = null;

    #[ORM\ManyToOne(inversedBy: 'accessoiresQuantities')]
    private ?Size $size = null;

    #[ORM\Column(length: 255)]
    private ?string $stock = null;

    public function getId(): ?int
    {
        return $this->id;
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
}
