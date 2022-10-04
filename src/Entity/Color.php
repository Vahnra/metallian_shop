<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ColorRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ColorRepository::class)]
class Color implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $color = null;

    #[ORM\OneToMany(mappedBy: 'color', targetEntity: AccessoiresQuantity::class)]
    private Collection $accessoiresQuantities;

    #[ORM\OneToMany(mappedBy: 'color', targetEntity: VetementQuantity::class, orphanRemoval: true)]
    private Collection $vetementQuantities;

    #[ORM\OneToMany(mappedBy: 'color', targetEntity: BijouxQuantity::class, orphanRemoval: true)]
    private Collection $bijouxQuantities;

    #[ORM\OneToMany(mappedBy: 'color', targetEntity: ChaussuresQuantity::class, orphanRemoval: true)]
    private Collection $chaussuresQuantities;

    #[ORM\OneToMany(mappedBy: 'color', targetEntity: VetementMerchandisingQuantity::class, orphanRemoval: true)]
    private Collection $vetementMerchandisingQuantities;

    #[ORM\OneToMany(mappedBy: 'color', targetEntity: AccessoiresMerchandisingQuantity::class, orphanRemoval: true)]
    private Collection $accessoiresMerchandisingQuantities;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    public function __construct()
    {
        $this->vetements = new ArrayCollection();
        $this->chaussures = new ArrayCollection();
        $this->bijouxes = new ArrayCollection();
        $this->accessoires = new ArrayCollection();
        $this->vetementMerchandisings = new ArrayCollection();
        $this->accessoiresMerchandisings = new ArrayCollection();
        $this->accessoiresQuantities = new ArrayCollection();
        $this->vetementQuantities = new ArrayCollection();
        $this->bijouxQuantities = new ArrayCollection();
        $this->chaussuresQuantities = new ArrayCollection();
        $this->vetementMerchandisingQuantities = new ArrayCollection();
        $this->accessoiresMerchandisingQuantities = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->color; 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, AccessoiresQuantity>
     */
    public function getAccessoiresQuantities(): Collection
    {
        return $this->accessoiresQuantities;
    }

    public function addAccessoiresQuantity(AccessoiresQuantity $accessoiresQuantity): self
    {
        if (!$this->accessoiresQuantities->contains($accessoiresQuantity)) {
            $this->accessoiresQuantities->add($accessoiresQuantity);
            $accessoiresQuantity->setColor($this);
        }

        return $this;
    }

    public function removeAccessoiresQuantity(AccessoiresQuantity $accessoiresQuantity): self
    {
        if ($this->accessoiresQuantities->removeElement($accessoiresQuantity)) {
            // set the owning side to null (unless already changed)
            if ($accessoiresQuantity->getColor() === $this) {
                $accessoiresQuantity->setColor(null);
            }
        }

        return $this;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

    /**
     * @return Collection<int, VetementQuantity>
     */
    public function getVetementQuantities(): Collection
    {
        return $this->vetementQuantities;
    }

    public function addVetementQuantity(VetementQuantity $vetementQuantity): self
    {
        if (!$this->vetementQuantities->contains($vetementQuantity)) {
            $this->vetementQuantities->add($vetementQuantity);
            $vetementQuantity->setColor($this);
        }

        return $this;
    }

    public function removeVetementQuantity(VetementQuantity $vetementQuantity): self
    {
        if ($this->vetementQuantities->removeElement($vetementQuantity)) {
            // set the owning side to null (unless already changed)
            if ($vetementQuantity->getColor() === $this) {
                $vetementQuantity->setColor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BijouxQuantity>
     */
    public function getBijouxQuantities(): Collection
    {
        return $this->bijouxQuantities;
    }

    public function addBijouxQuantity(BijouxQuantity $bijouxQuantity): self
    {
        if (!$this->bijouxQuantities->contains($bijouxQuantity)) {
            $this->bijouxQuantities->add($bijouxQuantity);
            $bijouxQuantity->setColor($this);
        }

        return $this;
    }

    public function removeBijouxQuantity(BijouxQuantity $bijouxQuantity): self
    {
        if ($this->bijouxQuantities->removeElement($bijouxQuantity)) {
            // set the owning side to null (unless already changed)
            if ($bijouxQuantity->getColor() === $this) {
                $bijouxQuantity->setColor(null);
            }
        }

        return $this;
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
            $chaussuresQuantity->setColor($this);
        }

        return $this;
    }

    public function removeChaussuresQuantity(ChaussuresQuantity $chaussuresQuantity): self
    {
        if ($this->chaussuresQuantities->removeElement($chaussuresQuantity)) {
            // set the owning side to null (unless already changed)
            if ($chaussuresQuantity->getColor() === $this) {
                $chaussuresQuantity->setColor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, VetementMerchandisingQuantity>
     */
    public function getVetementMerchandisingQuantities(): Collection
    {
        return $this->vetementMerchandisingQuantities;
    }

    public function addVetementMerchandisingQuantity(VetementMerchandisingQuantity $vetementMerchandisingQuantity): self
    {
        if (!$this->vetementMerchandisingQuantities->contains($vetementMerchandisingQuantity)) {
            $this->vetementMerchandisingQuantities->add($vetementMerchandisingQuantity);
            $vetementMerchandisingQuantity->setColor($this);
        }

        return $this;
    }

    public function removeVetementMerchandisingQuantity(VetementMerchandisingQuantity $vetementMerchandisingQuantity): self
    {
        if ($this->vetementMerchandisingQuantities->removeElement($vetementMerchandisingQuantity)) {
            // set the owning side to null (unless already changed)
            if ($vetementMerchandisingQuantity->getColor() === $this) {
                $vetementMerchandisingQuantity->setColor(null);
            }
        }

        return $this;
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
            $accessoiresMerchandisingQuantity->setColor($this);
        }

        return $this;
    }

    public function removeAccessoiresMerchandisingQuantity(AccessoiresMerchandisingQuantity $accessoiresMerchandisingQuantity): self
    {
        if ($this->accessoiresMerchandisingQuantities->removeElement($accessoiresMerchandisingQuantity)) {
            // set the owning side to null (unless already changed)
            if ($accessoiresMerchandisingQuantity->getColor() === $this) {
                $accessoiresMerchandisingQuantity->setColor(null);
            }
        }

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
