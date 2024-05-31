<?php

namespace App\Entity;

use App\Repository\FavoritesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoritesRepository::class)]
class Favorites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, book>
     */
    #[ORM\OneToMany(targetEntity: book::class, mappedBy: 'favorites')]
    private Collection $id_livre;

    /**
     * @var Collection<int, users>
     */
    #[ORM\OneToMany(targetEntity: users::class, mappedBy: 'favorites')]
    private Collection $id_user;

    public function __construct()
    {
        $this->id_livre = new ArrayCollection();
        $this->id_user = new ArrayCollection();
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
            $idLivre->setFavorites($this);
        }

        return $this;
    }

    public function removeIdLivre(book $idLivre): static
    {
        if ($this->id_livre->removeElement($idLivre)) {
            // set the owning side to null (unless already changed)
            if ($idLivre->getFavorites() === $this) {
                $idLivre->setFavorites(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, users>
     */
    public function getIdUser(): Collection
    {
        return $this->id_user;
    }

    public function addIdUser(users $idUser): static
    {
        if (!$this->id_user->contains($idUser)) {
            $this->id_user->add($idUser);
            $idUser->setFavorites($this);
        }

        return $this;
    }

    public function removeIdUser(users $idUser): static
    {
        if ($this->id_user->removeElement($idUser)) {
            // set the owning side to null (unless already changed)
            if ($idUser->getFavorites() === $this) {
                $idUser->setFavorites(null);
            }
        }

        return $this;
    }
}
