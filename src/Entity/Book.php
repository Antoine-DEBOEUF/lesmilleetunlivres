<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $isbn = null;

    #[ORM\Column]
    private ?int $publishing_date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $synopsis = null;

    #[ORM\Column]
    private ?bool $active = null;

    /**
     * @var Collection<int, Commentaries>
     */
    #[ORM\OneToMany(targetEntity: Commentaries::class, mappedBy: 'id_livre')]
    private Collection $commentaries;

    #[ORM\ManyToOne(inversedBy: 'id_livre')]
    private ?BookCategories $bookCategories = null;

    #[ORM\ManyToOne(inversedBy: 'id_livre')]
    private ?Favorites $favorites = null;

    public function __construct()
    {
        $this->commentaries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getIsbn(): ?int
    {
        return $this->isbn;
    }

    public function setIsbn(int $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getPublishingDate(): ?int
    {
        return $this->publishing_date;
    }

    public function setPublishingDate(int $publishing_date): static
    {
        $this->publishing_date = $publishing_date;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, Commentaries>
     */
    public function getCommentaries(): Collection
    {
        return $this->commentaries;
    }

    public function addCommentary(Commentaries $commentary): static
    {
        if (!$this->commentaries->contains($commentary)) {
            $this->commentaries->add($commentary);
            $commentary->setIdLivre($this);
        }

        return $this;
    }

    public function removeCommentary(Commentaries $commentary): static
    {
        if ($this->commentaries->removeElement($commentary)) {
            // set the owning side to null (unless already changed)
            if ($commentary->getIdLivre() === $this) {
                $commentary->setIdLivre(null);
            }
        }

        return $this;
    }

    public function getBookCategories(): ?BookCategories
    {
        return $this->bookCategories;
    }

    public function setBookCategories(?BookCategories $bookCategories): static
    {
        $this->bookCategories = $bookCategories;

        return $this;
    }

    public function getFavorites(): ?Favorites
    {
        return $this->favorites;
    }

    public function setFavorites(?Favorites $favorites): static
    {
        $this->favorites = $favorites;

        return $this;
    }
}
