<?php

/**
 * @Author: Gallarian <gallarian@gmail.com>
 */

namespace App\Entity\Helper;

use Doctrine\ORM\Mapping as ORM;

trait UpdatedAtTrait
{
    /**
     * @var array<mixed>
     * @ORM\Column(type="array")
     */
    protected array $updatedAt = [];

    /**
     * @return array<mixed>|null
     */
    public function getUpdatedAt(): ?array
    {
        return $this->updatedAt;
    }

    /**
     * @param array<mixed> $updatedAt
     * @return $this
     */
    public function setUpdatedAt(array $updatedAt): self
    {
        array_push($this->updatedAt, $updatedAt);

        return $this;
    }
}
