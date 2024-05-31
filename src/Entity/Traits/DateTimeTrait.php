<?php

namespace App\Entity\Traits;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait DateTimeTrait
{
    #[ORM\Column()]
    private ?DateTimeImmutable $createdAt = null;



    /**
     * Get the value of createdAt
     *
     * @return ?DateTimeImmutable
     */
    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @param ?DateTimeImmutable $createdAt
     *
     * @return self
     */
    public function setCreatedAt(?DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }



    #[ORM\PrePersist]
    public function getAutoCreatedAt(): self
    {
        $this->createdAt = new DateTimeImmutable();
        return $this;
    }
}
