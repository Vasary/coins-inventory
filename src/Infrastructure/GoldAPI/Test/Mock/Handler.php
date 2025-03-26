<?php

declare(strict_types=1);

namespace Infrastructure\GoldAPI\Test\Mock;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Psr7\Response;

final class Handler
{
    private const string RESPONSE_BODY = '{"price_gram_22k": "10", "price_gram_24k": "20"}';

    public function __construct(private MockHandler $handler)
    {
    }

    public function __invoke(RequestInterface $request, array $options): PromiseInterface
    {
        $this->handler->append(new Response(200, [], self::RESPONSE_BODY));

        return $this->handler->__invoke($request, $options);
    }
}
