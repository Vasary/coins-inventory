<?php

declare(strict_types=1);

namespace Infrastructure\GoldAPI\Guzzle;

use Domain\Common\Enum\Metal;
use Domain\Common\ValueObject\Money;
use Domain\Market\Repository\MarketRepositoryInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Infrastructure\Money\Service\MoneyInitializerService;
use Psr\Log\LoggerInterface;

final readonly class GoldAPIRepository implements MarketRepositoryInterface
{
    public function __construct(
        private ClientInterface $client,
        private MoneyInitializerService $moneyInitializer,
        private LoggerInterface $logger,
    ) {
    }


    public function metalPricePerGram(Metal $metal, int $karat, string $currency): Money
    {
        $metalCode = $this->resolveMetalCode($metal);
        $url = "{$metalCode}/{$currency}";

        return $this->fetchMetalPrice($url, $karat, $currency);
    }

    private function resolveMetalCode(Metal $metal): string
    {
        return match ($metal) {
            Metal::Gold => 'XAU',
        };
    }

    private function fetchMetalPrice(string $url, int $karat, string $currency): Money
    {
        return $this->client->getAsync($url)
            ->then(
                fn(Response $response) => $this->parseResponse($response, $karat, $currency),
                fn(RequestException $e) => $this->handleRequestException($e, $currency)
            )
            ->wait();
    }

    private function parseResponse(Response $response, int $karat, string $currency): Money
    {
        $data = json_decode($response->getBody()->getContents(), true);
        $key = "price_gram_{$karat}k";

        $price = isset($data[$key]) ? (int) round($data[$key] * 100) : 0;

        return $this->moneyInitializer->create($price, $currency);
    }

    private function handleRequestException(RequestException $exception, string $currency): void
    {
        $error = $exception->getMessage();
        if ($exception->hasResponse()) {
            $error .= ' - ' . $exception->getResponse()->getBody()->getContents();
        }

        $this->logger->error($error);

        $this->moneyInitializer->create(0, $currency);
    }
}
