<?php

declare(strict_types=1);

namespace Presentation\API\HTTP\Coin;

use Application\UseCase\Coin\Find\FindAllCoinsUseCase;
use Infrastructure\Framework\Symfony\Routing\Controller;
use Infrastructure\Framework\Symfony\Routing\JsonStreamedResponse;
use Infrastructure\Framework\Symfony\Routing\StatusCodeInterface;

final class FindCoinsController extends Controller
{
    public function __invoke(FindAllCoinsUseCase $useCase): JsonStreamedResponse
    {
        return new JsonStreamedResponse($useCase(), StatusCodeInterface::STATUS_OK);
    }
}
