<?php

/**
 * @Author: Gallarian <gallarian@gmail.com>
 */

namespace App\Service;

use App\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;

class LoggerService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function log(
        string $service,
        string $action,
        string $type,
        string $message,
        ?string $originalMessage = null
    ): void {
        $log = new Log($service, $action, $type, $message, $originalMessage);

        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }
}
