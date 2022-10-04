<?php

namespace App\Entity;

use App\Repository\SizeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SizeRepository::class)]
class Size implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $size = null;

    #[ORM\OneToMany(mappedBy: 'size', targetEntity: AccessoiresQuantity::class)]
    private Collection $accessoiresQuantities;

    #[ORM\OneToMany(mappedBy: 'size', targetEntity: VetementQuantity::class, orphanRemoval: true)]
    private Collection $vetementQuantities;

    #[ORM\OneToMany(mappedBy: 'size', targetEntity: ChaussuresQuantity::class, orphanRemoval: true)]
    private Collection $chaussuresQuantities;

    #[ORM\OneToMany(mappedBy: 'size', targetEntity: VetementMerchandisingQuantity::class, orphanRemoval: true)]
    private Collection $vetementMerchandisingQuantities;

    #[ORM\OneToMany(mappedBy: 'size', targetEntity: AccessoiresMerchandisingQuantity::class, orphanRemoval: true)]
    private Collection $accessoiresMerchandisingQuantities;

    public function __construct()
    {
        $this->vetements = new ArrayCollection();
        $this->chaussures = new ArrayCollection();
        $this->accessoires = new ArrayCollection();
        $this->vetementMerchandisings = new ArrayCollection();
        $this->accessoiresMerchandisings = new ArrayCollection();
        $this->accessoiresQuantities = new ArrayCollection();
        $this->vetementQuantities = new ArrayCollection();
        $this->chaussuresQuantities = new ArrayCollection();
        $this->vetementMerchandisingQuantities = new ArrayCollection();
        $this->accessoiresMerchandisingQuantities = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->size; 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

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
            $accessoiresQuantity->setSize($this);
        }

        return $this;
    }

    public function removeAccessoiresQuantity(AccessoiresQuantity $accessoiresQuantity): self
    {
        if ($this->accessoiresQuantities->removeElement($accessoiresQuantity)) {
            // set the owning side to null (unless already changed)
            if ($accessoiresQuantity->getSize() === $this) {
                $accessoiresQuantity->setSize(null);
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
            $vetementQuantity->setSize($this);
        }

        return $this;
    }

    public function removeVetementQuantity(VetementQuantity $vetementQuantity): self
    {
        if ($this->vetementQuantities->removeElement($vetementQuantity)) {
            // set the owning side to null (unless already changed)
            if ($vetementQuantity->getSize() === $this) {
                $vetementQuantity->setSize(null);
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
            $chaussuresQuantity->setSize($this);
        }

        return $this;
    }

    public function removeChaussuresQuantity(ChaussuresQuantity $chaussuresQuantity): self
    {
        if ($this->chaussuresQuantities->removeElement($chaussuresQuantity)) {
            // set the owning side to null (unless already changed)
            if ($chaussuresQuantity->getSize() === $this) {
                $chaussuresQuantity->setSize(null);
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
            $vetementMerchandisingQuantity->setSize($this);
        }

        return $this;
    }

    public function removeVetementMerchandisingQuantity(VetementMerchandisingQuantity $vetementMerchandisingQuantity): self
    {
        if ($this->vetementMerchandisingQuantities->removeElement($vetementMerchandisingQuantity)) {
            // set the owning side to null (unless already changed)
            if ($vetementMerchandisingQuantity->getSize() === $this) {
                $vetementMerchandisingQuantity->setSize(null);
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
            $accessoiresMerchandisingQuantity->setSize($this);
        }

        return $this;
    }

    public function removeAccessoiresMerchandisingQuantity(AccessoiresMerchandisingQuantity $accessoiresMerchandisingQuantity): self
    {
        if ($this->accessoiresMerchandisingQuantities->removeElement($accessoiresMerchandisingQuantity)) {
            // set the owning side to null (unless already changed)
            if ($accessoiresMerchandisingQuantity->getSize() === $this) {
                $accessoiresMerchandisingQuantity->setSize(null);
            }
        }

        return $this;
    }
}
