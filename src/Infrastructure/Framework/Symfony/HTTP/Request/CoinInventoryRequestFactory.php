<?php

declare(strict_types=1);

namespace Infrastructure\Framework\Symfony\HTTP\Request;

use Symfony\Component\HttpFoundation\Request;

final class CoinInventoryRequestFactory
{
    public static function register(): void
    {
        Request::setFactory(function (
            array $query = [],
            array $request = [],
            array $attributes = [],
            array $cookies = [],
            array $files = [],
            array $server = [],
            $content = null
        ) {
            return new CoinRequest(
                $query,
                $request,
                $attributes,
                $cookies,
                $files,
                $server,
                $content
            );
        });
    }
}
