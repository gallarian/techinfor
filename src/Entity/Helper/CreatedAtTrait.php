<?php

/**
 * @Author: Gallarian <gallarian@gmail.com>
 */

namespace App\Entity\Helper;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait CreatedAtTrait
{
    /**
     * @ORM\Column(type="datetime_immutable", options={"default" : "CURRENT_TIMESTAMP"})
     */
    protected DateTimeImmutable $createdAt;

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
}
