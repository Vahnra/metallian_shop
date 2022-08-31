<?php

namespace App\Entity;

use App\Repository\SousCategorieMerchandisingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SousCategorieMerchandisingRepository::class)]
class SousCategorieMerchandising
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'sousCategorieMerchandisings')]
    private ?CategorieMerchandising $categorieMerchandising = null;

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

    public function getCategorieMerchandising(): ?CategorieMerchandising
    {
        return $this->categorieMerchandising;
    }

    public function setCategorieMerchandising(?CategorieMerchandising $categorieMerchandising): self
    {
        $this->categorieMerchandising = $categorieMerchandising;

        return $this;
    }
}
