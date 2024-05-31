<?php

namespace App\Entity;

use App\Repository\BookCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookCategoriesRepository::class)]
class BookCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, book>
     */
    #[ORM\OneToMany(targetEntity: book::class, mappedBy: 'bookCategories')]
    private Collection $id_livre;

    /**
     * @var Collection<int, categories>
     */
    #[ORM\OneToMany(targetEntity: categories::class, mappedBy: 'bookCategories')]
    private Collection $id_category;

    public function __construct()
    {
        $this->id_livre = new ArrayCollection();
        $this->id_category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, book>
     */
    public function getIdLivre(): Collection
    {
        return $this->id_livre;
    }

    public function addIdLivre(book $idLivre): static
    {
        if (!$this->id_livre->contains($idLivre)) {
            $this->id_livre->add($idLivre);
            $idLivre->setBookCategories($this);
        }

        return $this;
    }

    public function removeIdLivre(book $idLivre): static
    {
        if ($this->id_livre->removeElement($idLivre)) {
            // set the owning side to null (unless already changed)
            if ($idLivre->getBookCategories() === $this) {
                $idLivre->setBookCategories(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, categories>
     */
    public function getIdCategory(): Collection
    {
        return $this->id_category;
    }

    public function addIdCategory(categories $idCategory): static
    {
        if (!$this->id_category->contains($idCategory)) {
            $this->id_category->add($idCategory);
            $idCategory->setBookCategories($this);
        }

        return $this;
    }

    public function removeIdCategory(categories $idCategory): static
    {
        if ($this->id_category->removeElement($idCategory)) {
            // set the owning side to null (unless already changed)
            if ($idCategory->getBookCategories() === $this) {
                $idCategory->setBookCategories(null);
            }
        }

        return $this;
    }
}
