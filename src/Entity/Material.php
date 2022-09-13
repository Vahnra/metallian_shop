<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterialRepository::class)]
class Material
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $material = null;

    #[ORM\OneToMany(mappedBy: 'material', targetEntity: Vetement::class)]
    private Collection $vetements;

    #[ORM\OneToMany(mappedBy: 'material', targetEntity: Accessoires::class)]
    private Collection $accessoires;

    #[ORM\OneToMany(mappedBy: 'material', targetEntity: Chaussures::class)]
    private Collection $chaussures;

    #[ORM\OneToMany(mappedBy: 'material', targetEntity: VetementMerchandising::class)]
    private Collection $vetementMerchandisings;

    #[ORM\OneToMany(mappedBy: 'material', targetEntity: AccessoiresMerchandising::class)]
    private Collection $accessoiresMerchandisings;

    public function __construct()
    {
        $this->vetements = new ArrayCollection();
        $this->accessoires = new ArrayCollection();
        $this->chaussures = new ArrayCollection();
        $this->vetementMerchandisings = new ArrayCollection();
        $this->accessoiresMerchandisings = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->material; 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaterial(): ?string
    {
        return $this->material;
    }

    public function setMaterial(string $material): self
    {
        $this->material = $material;

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
            $vetement->setMaterial($this);
        }

        return $this;
    }

    public function removeVetement(Vetement $vetement): self
    {
        if ($this->vetements->removeElement($vetement)) {
            // set the owning side to null (unless already changed)
            if ($vetement->getMaterial() === $this) {
                $vetement->setMaterial(null);
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
            $accessoire->setMaterial($this);
        }

        return $this;
    }

    public function removeAccessoire(Accessoires $accessoire): self
    {
        if ($this->accessoires->removeElement($accessoire)) {
            // set the owning side to null (unless already changed)
            if ($accessoire->getMaterial() === $this) {
                $accessoire->setMaterial(null);
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
            $chaussure->setMaterial($this);
        }

        return $this;
    }

    public function removeChaussure(Chaussures $chaussure): self
    {
        if ($this->chaussures->removeElement($chaussure)) {
            // set the owning side to null (unless already changed)
            if ($chaussure->getMaterial() === $this) {
                $chaussure->setMaterial(null);
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
            $vetementMerchandising->setMaterial($this);
        }

        return $this;
    }

    public function removeVetementMerchandising(VetementMerchandising $vetementMerchandising): self
    {
        if ($this->vetementMerchandisings->removeElement($vetementMerchandising)) {
            // set the owning side to null (unless already changed)
            if ($vetementMerchandising->getMaterial() === $this) {
                $vetementMerchandising->setMaterial(null);
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
            $accessoiresMerchandising->setMaterial($this);
        }

        return $this;
    }

    public function removeAccessoiresMerchandising(AccessoiresMerchandising $accessoiresMerchandising): self
    {
        if ($this->accessoiresMerchandisings->removeElement($accessoiresMerchandising)) {
            // set the owning side to null (unless already changed)
            if ($accessoiresMerchandising->getMaterial() === $this) {
                $accessoiresMerchandising->setMaterial(null);
            }
        }

        return $this;
    }
}
