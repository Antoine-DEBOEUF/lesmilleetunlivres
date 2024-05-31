<?php

namespace App\Entity;

use App\Repository\CommentariesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentariesRepository::class)]
class Commentaries
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commentaries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?users $id_user = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\ManyToOne(inversedBy: 'commentaries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?book $id_livre = null;

    #[ORM\ManyToOne(inversedBy: 'id_commentary')]
    private ?Reports $reports = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?users
    {
        return $this->id_user;
    }

    public function setIdUser(?users $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

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

    public function getIdLivre(): ?book
    {
        return $this->id_livre;
    }

    public function setIdLivre(?book $id_livre): static
    {
        $this->id_livre = $id_livre;

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
}
