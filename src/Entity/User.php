<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $firstname = null;

    #[ORM\Column(length: 50)]
    private ?string $lastname = null;

    #[ORM\Column(length: 10)]
    private ?string $gender = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletedAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ReviewVetement::class)]
    private Collection $reviewVetements;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ReviewMedia::class)]
    private Collection $reviewMedia;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserPostalAdress::class)]
    private Collection $postalAdress;

    #[ORM\Column(nullable: true)]
    private ?int $phoneNumber = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthdayDate = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Cart::class)]
    private Collection $carts;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: FavoriteProduct::class, orphanRemoval: true)]
    private Collection $favoriteProducts;

    public function __construct()
    {
        $this->reviewVetements = new ArrayCollection();
        $this->reviewMedia = new ArrayCollection();
        $this->postalAdress = new ArrayCollection();
        $this->carts = new ArrayCollection();
        $this->favoriteProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Collection<int, ReviewVetement>
     */
    public function getReviewVetements(): Collection
    {
        return $this->reviewVetements;
    }

    public function addReviewVetement(ReviewVetement $reviewVetement): self
    {
        if (!$this->reviewVetements->contains($reviewVetement)) {
            $this->reviewVetements->add($reviewVetement);
            $reviewVetement->setUser($this);
        }

        return $this;
    }

    public function removeReviewVetement(ReviewVetement $reviewVetement): self
    {
        if ($this->reviewVetements->removeElement($reviewVetement)) {
            // set the owning side to null (unless already changed)
            if ($reviewVetement->getUser() === $this) {
                $reviewVetement->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReviewMedia>
     */
    public function getReviewMedia(): Collection
    {
        return $this->reviewMedia;
    }

    public function addReviewMedium(ReviewMedia $reviewMedium): self
    {
        if (!$this->reviewMedia->contains($reviewMedium)) {
            $this->reviewMedia->add($reviewMedium);
            $reviewMedium->setUser($this);
        }

        return $this;
    }

    public function removeReviewMedium(ReviewMedia $reviewMedium): self
    {
        if ($this->reviewMedia->removeElement($reviewMedium)) {
            // set the owning side to null (unless already changed)
            if ($reviewMedium->getUser() === $this) {
                $reviewMedium->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserPostalAdress>
     */
    public function getPostalAdress(): Collection
    {
        return $this->postalAdress;
    }

    public function addPostalAdress(UserPostalAdress $postalAdress): self
    {
        if (!$this->postalAdress->contains($postalAdress)) {
            $this->postalAdress->add($postalAdress);
            $postalAdress->setUser($this);
        }

        return $this;
    }

    public function removePostalAdress(UserPostalAdress $postalAdress): self
    {
        if ($this->postalAdress->removeElement($postalAdress)) {
            // set the owning side to null (unless already changed)
            if ($postalAdress->getUser() === $this) {
                $postalAdress->setUser(null);
            }
        }

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getBirthdayDate(): ?\DateTimeInterface
    {
        return $this->birthdayDate;
    }

    public function setBirthdayDate(?\DateTimeInterface $birthdayDate): self
    {
        $this->birthdayDate = $birthdayDate;

        return $this;
    }

    /**
     * @return Collection<int, Cart>
     */
    public function getCarts(): Collection
    {
        return $this->carts;
    }

    public function addCart(Cart $cart): self
    {
        if (!$this->carts->contains($cart)) {
            $this->carts->add($cart);
            $cart->setUser($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): self
    {
        if ($this->carts->removeElement($cart)) {
            // set the owning side to null (unless already changed)
            if ($cart->getUser() === $this) {
                $cart->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FavoriteProduct>
     */
    public function getFavoriteProducts(): Collection
    {
        return $this->favoriteProducts;
    }

    public function addFavoriteProduct(FavoriteProduct $favoriteProduct): self
    {
        if (!$this->favoriteProducts->contains($favoriteProduct)) {
            $this->favoriteProducts->add($favoriteProduct);
            $favoriteProduct->setUser($this);
        }

        return $this;
    }

    public function removeFavoriteProduct(FavoriteProduct $favoriteProduct): self
    {
        if ($this->favoriteProducts->removeElement($favoriteProduct)) {
            // set the owning side to null (unless already changed)
            if ($favoriteProduct->getUser() === $this) {
                $favoriteProduct->setUser(null);
            }
        }

        return $this;
    }
}
