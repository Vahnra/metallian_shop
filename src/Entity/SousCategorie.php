<?php

namespace App\Entity;

use App\Repository\SousCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SousCategorieRepository::class)]
class SousCategorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sousCategories')]
    private ?Categorie $categorie = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'sousCategorie', targetEntity: Vetement::class)]
    private Collection $vetements;

    #[ORM\OneToMany(mappedBy: 'sousCategorie', targetEntity: Media::class)]
    private Collection $media;

    #[ORM\OneToMany(mappedBy: 'sousCategorie', targetEntity: Accessoires::class)]
    private Collection $accessoires;

    #[ORM\OneToMany(mappedBy: 'sousCategorie', targetEntity: Chaussures::class)]
    private Collection $chaussures;

    #[ORM\OneToMany(mappedBy: 'sousCategorie', targetEntity: Bijoux::class)]
    private Collection $bijouxes;

    #[ORM\OneToMany(mappedBy: 'sousCategorie', targetEntity: Product::class)]
    private Collection $products;

    public function __construct()
    {
        $this->vetements = new ArrayCollection();
        $this->media = new ArrayCollection();
        $this->accessoires = new ArrayCollection();
        $this->chaussures = new ArrayCollection();
        $this->bijouxes = new ArrayCollection();
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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
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
            $vetement->setSousCategorie($this);
        }

        return $this;
    }

    public function removeVetement(Vetement $vetement): self
    {
        if ($this->vetements->removeElement($vetement)) {
            // set the owning side to null (unless already changed)
            if ($vetement->getSousCategorie() === $this) {
                $vetement->setSousCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): self
    {
        if (!$this->media->contains($medium)) {
            $this->media->add($medium);
            $medium->setSousCategorie($this);
        }

        return $this;
    }

    public function removeMedium(Media $medium): self
    {
        if ($this->media->removeElement($medium)) {
            // set the owning side to null (unless already changed)
            if ($medium->getSousCategorie() === $this) {
                $medium->setSousCategorie(null);
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
            $accessoire->setSousCategorie($this);
        }

        return $this;
    }

    public function removeAccessoire(Accessoires $accessoire): self
    {
        if ($this->accessoires->removeElement($accessoire)) {
            // set the owning side to null (unless already changed)
            if ($accessoire->getSousCategorie() === $this) {
                $accessoire->setSousCategorie(null);
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
            $chaussure->setSousCategorie($this);
        }

        return $this;
    }

    public function removeChaussure(Chaussures $chaussure): self
    {
        if ($this->chaussures->removeElement($chaussure)) {
            // set the owning side to null (unless already changed)
            if ($chaussure->getSousCategorie() === $this) {
                $chaussure->setSousCategorie(null);
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
            $bijoux->setSousCategorie($this);
        }

        return $this;
    }

    public function removeBijoux(Bijoux $bijoux): self
    {
        if ($this->bijouxes->removeElement($bijoux)) {
            // set the owning side to null (unless already changed)
            if ($bijoux->getSousCategorie() === $this) {
                $bijoux->setSousCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setSousCategorie($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getSousCategorie() === $this) {
                $product->setSousCategorie(null);
            }
        }

        return $this;
    }
    
    

}
