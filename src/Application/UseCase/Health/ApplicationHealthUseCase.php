<?php

declare(strict_types=1);

namespace Application\UseCase\Health;

use Application\Service\Health\DatabaseHealthServiceInterface;

final readonly class ApplicationHealthUseCase
{
    public function __construct(
        private DatabaseHealthServiceInterface $databaseHealthService,
    ) {
    }

    public function __invoke(): bool
    {
        return $this->databaseHealthService->isHealthy();
    }
}
