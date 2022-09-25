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

    #[ORM\OneToMany(mappedBy: 'color', targetEntity: Vetement::class)]
    private Collection $vetements;

    #[ORM\OneToMany(mappedBy: 'color', targetEntity: Chaussures::class)]
    private Collection $chaussures;

    #[ORM\OneToMany(mappedBy: 'color', targetEntity: Bijoux::class)]
    private Collection $bijouxes;

    #[ORM\OneToMany(mappedBy: 'color', targetEntity: Accessoires::class)]
    private Collection $accessoires;

    #[ORM\OneToMany(mappedBy: 'color', targetEntity: VetementMerchandising::class)]
    private Collection $vetementMerchandisings;

    #[ORM\OneToMany(mappedBy: 'color', targetEntity: AccessoiresMerchandising::class)]
    private Collection $accessoiresMerchandisings;

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
     * @return Collection<int, Vetement>
     */
    public function getVetements(): Collection
    {
        return $this->vetements;
    }

    public function addVetement(Vetement $vetement): self
    {
        if (!$this->vetements->contains($vetement)) {
            $this->vetements->add($vetement);
            $vetement->setColor($this);
        }

        return $this;
    }

    public function removeVetement(Vetement $vetement): self
    {
        if ($this->vetements->removeElement($vetement)) {
            // set the owning side to null (unless already changed)
            if ($vetement->getColor() === $this) {
                $vetement->setColor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Chaussures>
     */
    public function getChaussures(): Collection
    {
        return $this->chaussures;
    }

    public function addChaussure(Chaussures $chaussure): self
    {
        if (!$this->chaussures->contains($chaussure)) {
            $this->chaussures->add($chaussure);
            $chaussure->setColor($this);
        }

        return $this;
    }

    public function removeChaussure(Chaussures $chaussure): self
    {
        if ($this->chaussures->removeElement($chaussure)) {
            // set the owning side to null (unless already changed)
            if ($chaussure->getColor() === $this) {
                $chaussure->setColor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Bijoux>
     */
    public function getBijouxes(): Collection
    {
        return $this->bijouxes;
    }

    public function addBijoux(Bijoux $bijoux): self
    {
        if (!$this->bijouxes->contains($bijoux)) {
            $this->bijouxes->add($bijoux);
            $bijoux->setColor($this);
        }

        return $this;
    }

    public function removeBijoux(Bijoux $bijoux): self
    {
        if ($this->bijouxes->removeElement($bijoux)) {
            // set the owning side to null (unless already changed)
            if ($bijoux->getColor() === $this) {
                $bijoux->setColor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Accessoires>
     */
    public function getAccessoires(): Collection
    {
        return $this->accessoires;
    }

    public function addAccessoire(Accessoires $accessoire): self
    {
        if (!$this->accessoires->contains($accessoire)) {
            $this->accessoires->add($accessoire);
            $accessoire->setColor($this);
        }

        return $this;
    }

    public function removeAccessoire(Accessoires $accessoire): self
    {
        if ($this->accessoires->removeElement($accessoire)) {
            // set the owning side to null (unless already changed)
            if ($accessoire->getColor() === $this) {
                $accessoire->setColor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, VetementMerchandising>
     */
    public function getVetementMerchandisings(): Collection
    {
        return $this->vetementMerchandisings;
    }

    public function addVetementMerchandising(VetementMerchandising $vetementMerchandising): self
    {
        if (!$this->vetementMerchandisings->contains($vetementMerchandising)) {
            $this->vetementMerchandisings->add($vetementMerchandising);
            $vetementMerchandising->setColor($this);
        }

        return $this;
    }

    public function removeVetementMerchandising(VetementMerchandising $vetementMerchandising): self
    {
        if ($this->vetementMerchandisings->removeElement($vetementMerchandising)) {
            // set the owning side to null (unless already changed)
            if ($vetementMerchandising->getColor() === $this) {
                $vetementMerchandising->setColor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AccessoiresMerchandising>
     */
    public function getAccessoiresMerchandisings(): Collection
    {
        return $this->accessoiresMerchandisings;
    }

    public function addAccessoiresMerchandising(AccessoiresMerchandising $accessoiresMerchandising): self
    {
        if (!$this->accessoiresMerchandisings->contains($accessoiresMerchandising)) {
            $this->accessoiresMerchandisings->add($accessoiresMerchandising);
            $accessoiresMerchandising->setColor($this);
        }

        return $this;
    }

    public function removeAccessoiresMerchandising(AccessoiresMerchandising $accessoiresMerchandising): self
    {
        if ($this->accessoiresMerchandisings->removeElement($accessoiresMerchandising)) {
            // set the owning side to null (unless already changed)
            if ($accessoiresMerchandising->getColor() === $this) {
                $accessoiresMerchandising->setColor(null);
            }
        }

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
}
