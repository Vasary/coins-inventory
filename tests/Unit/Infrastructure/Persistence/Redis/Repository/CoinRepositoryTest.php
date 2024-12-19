<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Redis\Repository;

use Domain\Coin\Model\Coin;
use Infrastructure\Test\TestCase;

final class CoinRepositoryTest extends TestCase
{
    public function testShouldGetAllCoins(): void
    {
        /** @var CoinRepository $repository */
        $repository = $this->getContainer()->get(CoinRepository::class);

        $coins = iterator_to_array($repository->finaAll());

        $this->assertCount(3, $coins);
        foreach ($coins as $coin) {
            $this->assertInstanceOf(Coin::class, $coin);
            $this->assertContains($coin, $coins);
        }
    }

    public function testShouldRemoveOneCoin(): void
    {
        /** @var CoinRepository $repository */
        $repository = $this->getContainer()->get(CoinRepository::class);

        /** @var Coin $coin */
        $coin = $repository->finaAll()->current();

        $repository->remove($coin);

        $restOfCoins = iterator_to_array($repository->finaAll());

        $this->assertCount(2, $restOfCoins);
        $this->assertNotContains($coin, $restOfCoins);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadCoinsFixture();
    }
}
