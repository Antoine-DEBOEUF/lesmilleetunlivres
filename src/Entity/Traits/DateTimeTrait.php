<?php

namespace App\Entity\Traits;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait DateTimeTrait
{
    #[ORM\Column(nullable: false)]
    private ?\DateTimeImmutable $createdAt = null;


    #[ORM\Column(nullable: true)]

    private ?\DateTimeImmutable $updatedAt = null;




    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }


    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }


    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function setAutoCreatedAt(): void
    {

        $this->createdAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate()]
    public function setAutoUpdatedAt(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }
}
