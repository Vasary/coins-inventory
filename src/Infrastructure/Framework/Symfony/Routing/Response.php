<?php

declare(strict_types=1);

namespace Infrastructure\Framework\Symfony\Routing;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\StreamedJsonResponse;

final class Response extends StreamedJsonResponse
{
    public const int STATUS_OK = SymfonyResponse::HTTP_OK;
    public const int INTERNAL_ERROR = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;
    public const int BAD_REQUEST = SymfonyResponse::HTTP_BAD_REQUEST;
}
