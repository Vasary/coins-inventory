<?php

declare(strict_types=1);

namespace Infrastructure\Framework\Symfony\Routing;

use Symfony\Component\HttpFoundation\JsonResponse as SymfonyJsonResponse;

final class JsonResponse extends SymfonyJsonResponse implements StatusCodeInterface
{
}
