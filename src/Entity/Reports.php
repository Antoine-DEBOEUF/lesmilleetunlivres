<?php

namespace App\Entity;

use App\Repository\ReportsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportsRepository::class)]
class Reports
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, commentaries>
     */
    #[ORM\OneToMany(targetEntity: commentaries::class, mappedBy: 'reports')]
    private Collection $id_commentary;

    /**
     * @var Collection<int, users>
     */
    #[ORM\OneToMany(targetEntity: users::class, mappedBy: 'reports')]
    private Collection $id_user;

    public function __construct()
    {
        $this->id_commentary = new ArrayCollection();
        $this->id_user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, commentaries>
     */
    public function getIdCommentary(): Collection
    {
        return $this->id_commentary;
    }

    public function addIdCommentary(commentaries $idCommentary): static
    {
        if (!$this->id_commentary->contains($idCommentary)) {
            $this->id_commentary->add($idCommentary);
            $idCommentary->setReports($this);
        }

        return $this;
    }

    public function removeIdCommentary(commentaries $idCommentary): static
    {
        if ($this->id_commentary->removeElement($idCommentary)) {
            // set the owning side to null (unless already changed)
            if ($idCommentary->getReports() === $this) {
                $idCommentary->setReports(null);
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
            $idUser->setReports($this);
        }

        return $this;
    }

    public function removeIdUser(users $idUser): static
    {
        if ($this->id_user->removeElement($idUser)) {
            // set the owning side to null (unless already changed)
            if ($idUser->getReports() === $this) {
                $idUser->setReports(null);
            }
        }

        return $this;
    }
}
