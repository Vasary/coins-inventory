<?php

declare(strict_types=1);

namespace Infrastructure\Framework\Symfony;

use Infrastructure\Framework\Symfony\HTTP\Request\CoinInventoryRequestFactory;
use Infrastructure\Framework\Symfony\HTTP\Request\CoinRequest;
use Infrastructure\Test\TestCase;
use Symfony\Component\HttpFoundation\Request;

final class RequestFactoryTest extends TestCase
{
    public function testFactoryShouldCreateCoinRequest(): void
    {
        CoinInventoryRequestFactory::register();

        $request = Request::createFromGlobals();

        $this->assertInstanceOf(CoinRequest::class, $request);
    }
}
