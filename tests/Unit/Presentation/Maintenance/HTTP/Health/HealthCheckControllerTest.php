<?php

declare(strict_types=1);

namespace Presentation\Maintenance\HTTP\Health;

use Application\UseCase\Health\ApplicationHealthUseCase;
use Infrastructure\Persistence\Redis\Service\DatabaseHealthService;
use Infrastructure\Test\TestCase;
use Predis\ClientInterface;

final class HealthCheckControllerTest extends TestCase
{
    public function testShouldSuccessfullyGetAliveApplicationResponse(): void
    {
        /** @var HealthCheckController $controller */
        $controller = $this->getContainer()->get(HealthCheckController::class);

        /** @var ApplicationHealthUseCase $useCase */
        $useCase = $this->getContainer()->get(ApplicationHealthUseCase::class);

        $this->assertEquals(200, $controller($useCase)->getStatusCode());
    }

    public function testShouldSuccessfullyGetDeadApplicationResponse(): void
    {
        $redisPingMock = $this->createMock(ClientInterface::class);
        $redisPingMock
            ->expects($this->once())
            ->method('__call')
            ->with('ping', [])
            ->willReturn('NO-PONG');

        $this->getContainer()->set(DatabaseHealthService::class, new DatabaseHealthService($redisPingMock));

        /** @var HealthCheckController $controller */
        $controller = $this->getContainer()->get(HealthCheckController::class);

        /** @var ApplicationHealthUseCase $useCase */
        $useCase = $this->getContainer()->get(ApplicationHealthUseCase::class);

        $this->assertEquals(500, $controller($useCase)->getStatusCode());
    }
}
