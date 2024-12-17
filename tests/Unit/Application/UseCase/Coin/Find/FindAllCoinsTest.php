<?php

declare(strict_types=1);

namespace Application\UseCase\Coin\Find;

use Application\UseCase\Coin\Find\DTO\Coin;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Infrastructure\Persistence\Redis\Repository\CoinRepository;
use Infrastructure\Test\Fixture\CoinFixture;
use Infrastructure\Test\TestCase;

final class FindAllCoinsTest extends TestCase
{
    public function testAddCoin(): void
    {
        /** @var FindAllCoinsUseCase $useCase */
        $useCase = $this->getContainer()->get(FindAllCoinsUseCase::class);

        $coins = iterator_to_array($useCase());

        $this->assertCount(3, $coins);

        $coin = $coins[0];
        $this->assertInstanceOf(Coin::class, $coin);

        $this->assertEquals('0193ce8c-5e87-7f73-81de-b17ef561d33c', $coin->id);
        $this->assertEquals('Britannia 1/2 oz Gold', $coin->name);
        $this->assertEquals('Gold investment coin', $coin->description);
        $this->assertEquals(0.15, $coin->purchasePrice);
        $this->assertEquals('EUR', $coin->purchaseCurrency);
        $this->assertEquals('gold', $coin->metal);
        $this->assertEquals(15.55, $coin->weight);
        $this->assertEquals(999.9, $coin->purity);
        $this->assertEquals(50, $coin->nominal);
        $this->assertEquals('unitedKingdom', $coin->country);
        $this->assertEquals(2024, $coin->year);
        $this->assertEquals(1262.69, $coin->marketValue);
    }

    protected function setUp(): void
    {
        parent::setUp();

        /** @var CoinRepository $repository */
        $repository = $this->getContainer()->get(CoinRepository::class);

        /** @var CoinFixture $fixtures */
        $fixtures = $this->getContainer()->get(CoinFixture::class);

        foreach ($fixtures->items() as $fixture) {
            $repository->add($fixture);
        }

        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . '/Response/market.json')),
            new Response(200, [], file_get_contents(__DIR__ . '/Response/market.json')),
            new Response(200, [], file_get_contents(__DIR__ . '/Response/market.json')),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $mockClient = new Client(['handler' => $handlerStack]);

        $this->getContainer()->set('guzzle.gold-api.client', $mockClient);
    }
}
