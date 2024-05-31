<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email()]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $password = null;

    #[ORM\Column]
    private array $role = [];

    #[ORM\Column]
    private ?bool $active = null;

    /**
     * @var Collection<int, Commentaries>
     */
    #[ORM\OneToMany(targetEntity: Commentaries::class, mappedBy: 'id_user')]
    private Collection $commentaries;

    #[ORM\ManyToOne(inversedBy: 'id_user')]
    private ?Favorites $favorites = null;

    #[ORM\ManyToOne(inversedBy: 'id_user')]
    private ?Reports $reports = null;

    /**
     * @var Collection<int, BanList>
     */
    #[ORM\OneToMany(targetEntity: BanList::class, mappedBy: 'id_user')]
    private Collection $banLists;

    public function __construct()
    {
        $this->commentaries = new ArrayCollection();
        $this->banLists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): array
    {
        return $this->role;
    }

    public function setRole(array $role): static
    {
        $this->role = $role;

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
            $commentary->setIdUser($this);
        }

        return $this;
    }

    public function removeCommentary(Commentaries $commentary): static
    {
        if ($this->commentaries->removeElement($commentary)) {
            // set the owning side to null (unless already changed)
            if ($commentary->getIdUser() === $this) {
                $commentary->setIdUser(null);
            }
        }

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

    public function getReports(): ?Reports
    {
        return $this->reports;
    }

    public function setReports(?Reports $reports): static
    {
        $this->reports = $reports;

        return $this;
    }

    /**
     * @return Collection<int, BanList>
     */
    public function getBanLists(): Collection
    {
        return $this->banLists;
    }

    public function addBanList(BanList $banList): static
    {
        if (!$this->banLists->contains($banList)) {
            $this->banLists->add($banList);
            $banList->setIdUser($this);
        }

        return $this;
    }

    public function removeBanList(BanList $banList): static
    {
        if ($this->banLists->removeElement($banList)) {
            // set the owning side to null (unless already changed)
            if ($banList->getIdUser() === $this) {
                $banList->setIdUser(null);
            }
        }

        return $this;
    }
}
