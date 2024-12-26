<?php

declare(strict_types=1);

namespace Domain\Coin\Model;

use Infrastructure\Money\Service\MoneyInitializerService;
use Infrastructure\Test\Fixture\CoinFixture;
use Infrastructure\Test\TestCase;

final class CoinTest extends TestCase
{
    public function testCoin(): void
    {
        /** @var CoinFixture $fixtures */
        $fixtures = $this->getContainer()->get(CoinFixture::class);

        /** @var MoneyInitializerService $moneyInitializer */
        $moneyInitializer = $this->getContainer()->get(MoneyInitializerService::class);

        $coin = $fixtures->eagle();

        $metalPrice = $moneyInitializer->create(8100, 'EUR');

        $this->assertInstanceOf(Coin::class, $coin);

        $this->assertEquals(31.103631, $coin->pureMetalWeight());
        $this->assertEquals(22, $coin->karats());
        $this->assertEquals(2519.39, $coin->metalPrice($metalPrice)->getAmount());
    }
}
