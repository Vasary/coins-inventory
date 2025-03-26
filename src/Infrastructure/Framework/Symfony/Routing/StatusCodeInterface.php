<?php

declare(strict_types=1);

namespace Infrastructure\Framework\Symfony\Routing;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

interface StatusCodeInterface
{
    public const int STATUS_OK = SymfonyResponse::HTTP_OK;
    public const int INTERNAL_ERROR = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;
    public const int BAD_REQUEST = SymfonyResponse::HTTP_BAD_REQUEST;
    public const int CREATED = SymfonyResponse::HTTP_CREATED;
}
