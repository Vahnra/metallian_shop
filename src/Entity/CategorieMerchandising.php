<?php

namespace App\Entity;

use App\Repository\CategorieMerchandisingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieMerchandisingRepository::class)]
class CategorieMerchandising
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'categorieMerchandising', targetEntity: SousCategorieMerchandising::class, cascade: ['remove'])]
    private Collection $sousCategorieMerchandisings;

    #[ORM\OneToMany(mappedBy: 'categorieMerchandising', targetEntity: VetementMerchandising::class, cascade: ['remove'])]
    private Collection $vetementMerchandisings;

    #[ORM\OneToMany(mappedBy: 'categorieMerchandising', targetEntity: AccessoiresMerchandising::class, cascade: ['remove'])]
    private Collection $accessoiresMerchandisings;

    #[ORM\OneToMany(mappedBy: 'categorieMerchandising', targetEntity: Products::class)]
    private Collection $products;

    public function __construct()
    {
        $this->sousCategorieMerchandisings = new ArrayCollection();
        $this->vetementMerchandisings = new ArrayCollection();
        $this->accessoiresMerchandisings = new ArrayCollection();
        $this->products = new ArrayCollection();
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
     * @return Collection<int, SousCategorieMerchandising>
     */
    public function getSousCategorieMerchandisings(): Collection
    {
        return $this->sousCategorieMerchandisings;
    }

    public function addSousCategorieMerchandising(SousCategorieMerchandising $sousCategorieMerchandising): self
    {
        if (!$this->sousCategorieMerchandisings->contains($sousCategorieMerchandising)) {
            $this->sousCategorieMerchandisings->add($sousCategorieMerchandising);
            $sousCategorieMerchandising->setCategorieMerchandising($this);
        }

        return $this;
    }

    public function removeSousCategorieMerchandising(SousCategorieMerchandising $sousCategorieMerchandising): self
    {
        if ($this->sousCategorieMerchandisings->removeElement($sousCategorieMerchandising)) {
            // set the owning side to null (unless already changed)
            if ($sousCategorieMerchandising->getCategorieMerchandising() === $this) {
                $sousCategorieMerchandising->setCategorieMerchandising(null);
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
            $vetementMerchandising->setCategorieMerchandising($this);
        }

        return $this;
    }

    public function removeVetementMerchandising(VetementMerchandising $vetementMerchandising): self
    {
        if ($this->vetementMerchandisings->removeElement($vetementMerchandising)) {
            // set the owning side to null (unless already changed)
            if ($vetementMerchandising->getCategorieMerchandising() === $this) {
                $vetementMerchandising->setCategorieMerchandising(null);
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
            $accessoiresMerchandising->setCategorieMerchandising($this);
        }

        return $this;
    }

    public function removeAccessoiresMerchandising(AccessoiresMerchandising $accessoiresMerchandising): self
    {
        if ($this->accessoiresMerchandisings->removeElement($accessoiresMerchandising)) {
            // set the owning side to null (unless already changed)
            if ($accessoiresMerchandising->getCategorieMerchandising() === $this) {
                $accessoiresMerchandising->setCategorieMerchandising(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Products>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Products $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategorieMerchandising($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategorieMerchandising() === $this) {
                $product->setCategorieMerchandising(null);
            }
        }

        return $this;
    }
}
