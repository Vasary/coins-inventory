<?php

declare(strict_types=1);

namespace Infrastructure\Framework\Symfony\Routing;

use Symfony\Component\HttpFoundation\StreamedJsonResponse;

final class JsonStreamedResponse extends StreamedJsonResponse implements StatusCodeInterface
{
}
