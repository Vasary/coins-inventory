<?php

declare(strict_types=1);

namespace Presentation\Maintenance\HTTP\Health;

use Application\UseCase\Health\ApplicationHealthUseCase;
use Infrastructure\Framework\Symfony\Routing\Controller;
use Infrastructure\Framework\Symfony\Routing\Response;

final class HealthCheckController extends Controller
{
    public function __invoke(ApplicationHealthUseCase $useCase): Response
    {
        return new Response([], $useCase() ? Response::STATUS_OK : Response::INTERNAL_ERROR);
    }
}
