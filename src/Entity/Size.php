<?php

namespace App\Entity;

use App\Repository\SizeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SizeRepository::class)]
class Size
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $size = null;

    #[ORM\OneToMany(mappedBy: 'size', targetEntity: Vetement::class)]
    private Collection $vetements;

    #[ORM\OneToMany(mappedBy: 'size', targetEntity: Chaussures::class)]
    private Collection $chaussures;

    #[ORM\OneToMany(mappedBy: 'size', targetEntity: Accessoires::class)]
    private Collection $accessoires;

    #[ORM\OneToMany(mappedBy: 'size', targetEntity: VetementMerchandising::class)]
    private Collection $vetementMerchandisings;

    #[ORM\OneToMany(mappedBy: 'size', targetEntity: AccessoiresMerchandising::class)]
    private Collection $accessoiresMerchandisings;

    public function __construct()
    {
        $this->vetements = new ArrayCollection();
        $this->chaussures = new ArrayCollection();
        $this->accessoires = new ArrayCollection();
        $this->vetementMerchandisings = new ArrayCollection();
        $this->accessoiresMerchandisings = new ArrayCollection();
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
            $vetement->setSize($this);
        }

        return $this;
    }

    public function removeVetement(Vetement $vetement): self
    {
        if ($this->vetements->removeElement($vetement)) {
            // set the owning side to null (unless already changed)
            if ($vetement->getSize() === $this) {
                $vetement->setSize(null);
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
            $chaussure->setSize($this);
        }

        return $this;
    }

    public function removeChaussure(Chaussures $chaussure): self
    {
        if ($this->chaussures->removeElement($chaussure)) {
            // set the owning side to null (unless already changed)
            if ($chaussure->getSize() === $this) {
                $chaussure->setSize(null);
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
            $accessoire->setSize($this);
        }

        return $this;
    }

    public function removeAccessoire(Accessoires $accessoire): self
    {
        if ($this->accessoires->removeElement($accessoire)) {
            // set the owning side to null (unless already changed)
            if ($accessoire->getSize() === $this) {
                $accessoire->setSize(null);
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
            $vetementMerchandising->setSize($this);
        }

        return $this;
    }

    public function removeVetementMerchandising(VetementMerchandising $vetementMerchandising): self
    {
        if ($this->vetementMerchandisings->removeElement($vetementMerchandising)) {
            // set the owning side to null (unless already changed)
            if ($vetementMerchandising->getSize() === $this) {
                $vetementMerchandising->setSize(null);
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
            $accessoiresMerchandising->setSize($this);
        }

        return $this;
    }

    public function removeAccessoiresMerchandising(AccessoiresMerchandising $accessoiresMerchandising): self
    {
        if ($this->accessoiresMerchandisings->removeElement($accessoiresMerchandising)) {
            // set the owning side to null (unless already changed)
            if ($accessoiresMerchandising->getSize() === $this) {
                $accessoiresMerchandising->setSize(null);
            }
        }

        return $this;
    }
}
