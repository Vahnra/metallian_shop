<?php

namespace App\Entity;

use App\Repository\MarquesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarquesRepository::class)]
class Marques
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'marques', targetEntity: VetementMerchandising::class)]
    private Collection $vetementMerchandisings;

    #[ORM\OneToMany(mappedBy: 'marques', targetEntity: Vetement::class)]
    private Collection $vetements;

    public function __construct()
    {
        $this->vetementMerchandisings = new ArrayCollection();
        $this->vetements = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title; 
    }

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
            $vetementMerchandising->setMarques($this);
        }

        return $this;
    }

    public function removeVetementMerchandising(VetementMerchandising $vetementMerchandising): self
    {
        if ($this->vetementMerchandisings->removeElement($vetementMerchandising)) {
            // set the owning side to null (unless already changed)
            if ($vetementMerchandising->getMarques() === $this) {
                $vetementMerchandising->setMarques(null);
            }
        }

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
            $vetement->setMarques($this);
        }

        return $this;
    }

    public function removeVetement(Vetement $vetement): self
    {
        if ($this->vetements->removeElement($vetement)) {
            // set the owning side to null (unless already changed)
            if ($vetement->getMarques() === $this) {
                $vetement->setMarques(null);
            }
        }

        return $this;
    }
}
