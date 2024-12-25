<?php

declare(strict_types=1);

namespace Application\Service\Health;

interface DatabaseHealthServiceInterface
{
    public function isHealthy(): bool;
}
