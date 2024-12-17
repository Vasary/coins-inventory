<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Coin\Factory;

use Domain\Coin\Factory\CoinFactory;
use Domain\Coin\Model\Coin;
use Domain\Common\Enum\Country;
use Domain\Common\Enum\Metal;
use Infrastructure\Test\TestCase;

final class CoinFactoryTest extends TestCase
{
    public function testCoinFactoryCanCreateNewCoin(): void
    {
        $factory = $this->getContainer()->get(CoinFactory::class);

        $coin = $factory->create('A', 'B', 1000, 'EUR', 'gold', 1.1, 1.01, 2, 'usa', 2015, '2024-12-14T13:37:22+00:00');

        $this->assertInstanceOf(Coin::class, $coin);
        $this->assertEquals('A', $coin->name);
        $this->assertEquals('B', $coin->description);
        $this->assertEquals('10.00', $coin->purchasePrice->getAmount());
        $this->assertEquals('EUR', $coin->purchasePrice->getCurrency());
        $this->assertEquals(Metal::Gold, $coin->metal);
        $this->assertEquals(1.1, $coin->weight);
        $this->assertEquals(1.01, $coin->purity);
        $this->assertEquals(2, $coin->nominal);
        $this->assertEquals(Country::USA, $coin->country);
        $this->assertEquals(2015, $coin->year);
        $this->assertEquals('2024-12-14T13:37:22+00:00', (string) $coin->purchaseDate);
    }
}
