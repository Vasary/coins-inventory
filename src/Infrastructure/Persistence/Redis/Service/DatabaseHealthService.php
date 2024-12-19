<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Redis\Service;

use Application\Service\Health\DatabaseHealthServiceInterface;
use Predis\ClientInterface;

final readonly class DatabaseHealthService implements DatabaseHealthServiceInterface
{
    public function __construct(private ClientInterface $client)
    {
    }

    public function isHealthy(): bool
    {
        return 'PONG' === (string) $this->client->ping();
    }
}
