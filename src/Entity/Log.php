<?php

/**
 * @Author: Gallarian <gallarian@gmail.com>
 */

namespace App\Entity;

use App\Entity\Helper\CreatedAtTrait;
use App\Repository\LogRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity(repositoryClass=LogRepository::class)
 * @ORM\Table(name="ti_logs")
 */
class Log
{
    use CreatedAtTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     * @ORM\Column(type="uuid")
     */
    private UuidV4 $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $service;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $action;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $type;

    /**
     * @ORM\Column(type="text")
     */
    private string $message;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $originalMessage;

    public function __construct(string $service, string $action, string $type, string $message, string $originalMessage = null)
    {
        $this->service = $service;
        $this->action = $action;
        $this->type = $type;
        $this->message = $message;
        $this->originalMessage = $originalMessage;
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?UuidV4
    {
        return $this->id;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(string $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getOriginalMessage(): ?string
    {
        return $this->originalMessage;
    }

    public function setOriginalMessage(?string $originalMessage): self
    {
        $this->originalMessage = $originalMessage;

        return $this;
    }
}
