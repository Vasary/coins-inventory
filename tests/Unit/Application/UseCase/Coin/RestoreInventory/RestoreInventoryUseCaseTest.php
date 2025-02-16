<?php

declare(strict_types=1);

namespace Application\UseCase\Coin\RestoreInventory;

use Application\UseCase\Coin\RestoreInventory\Data\Inventory;
use Domain\Coin\Model\Coin;
use Domain\Coin\Repository\RepositoryInterface;
use Generator;
use Infrastructure\Test\Fixture\CoinFixture;
use Infrastructure\Test\TestCase;
use PHPUnit\Framework\Assert;

final class RestoreInventoryUseCaseTest extends TestCase
{
    public function testShouldSuccessfullyImportPreparedInventory(): void
    {
        /** @var CoinFixture $coinFixture */
        $coinFixture = $this->getContainer()->get(CoinFixture::class);
        $testCoin = clone $coinFixture->eagle();

        /** @var Inventory $inventory */
        $inventory = $this->getContainer()->get(Inventory::class);
        $inventoryCoins = iterator_to_array($inventory->get());

        $repositoryMock = $this->createMock(RepositoryInterface::class);
        $repositoryMock
            ->expects($this->once())
            ->method('finaAll')
            ->willReturnCallback(fn (): Generator => yield $testCoin);

        $repositoryMock
            ->expects($this->once())
            ->method('remove')
            ->with($testCoin);

        $repositoryMock
            ->expects($this->exactly(count($inventoryCoins)))
            ->method('add')
            ->with($this->callback(function (Coin $coin) use (&$inventoryCoins) {
                $index = array_search($coin, $inventoryCoins);
                Assert::assertIsNumeric($index, 'Coin is not expected');

                return true;
            }));
        ;

        $useCase = new RestoreInventoryUseCase($inventory, $repositoryMock);

        $useCase->execute();
    }
}
