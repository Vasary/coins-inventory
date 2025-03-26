<?php

declare(strict_types=1);

namespace Presentation\Maintenance\HTTP\Health;

use Application\UseCase\Health\ApplicationHealthUseCase;
use Infrastructure\Framework\Symfony\Routing\Controller;
use Infrastructure\Framework\Symfony\Routing\JsonResponse;
use Infrastructure\Framework\Symfony\Routing\StatusCodeInterface;

final class HealthCheckController extends Controller
{
    public function __invoke(ApplicationHealthUseCase $useCase): JsonResponse
    {
        return new JsonResponse([], $useCase()
            ? StatusCodeInterface::STATUS_OK
            : StatusCodeInterface::INTERNAL_ERROR);
    }
}
