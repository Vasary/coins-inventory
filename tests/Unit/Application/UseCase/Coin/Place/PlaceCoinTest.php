<?php

declare(strict_types=1);

namespace Application\UseCase\Coin\Place;

use Application\UseCase\Coin\Place\Request\PlaceCoinRequest;
use Domain\Coin\Model\Coin;
use Infrastructure\Test\TestCase;

final class PlaceCoinTest extends TestCase
{
    public function testAddCoin(): void
    {
        /** @var PlaceCoinUseCase $useCase */
        $useCase = $this->getContainer()->get(PlaceCoinUseCase::class);

        $request = new PlaceCoinRequest(
            name: 'American Gold Eagle',
            description: 'The American Gold Eagle is a popular investment coin.',
            purchasePrice: 200000,
            purchaseCurrency: 'USD',
            metal: 'GOLD',
            weight: 31.1035,
            purity: 0.9167,
            nominal: 50,
            country: 'USA',
            year: 2023,
            purchaseDate: '2023-12-01T00:15:00+02:00',
        );

        $coin = $useCase($request);

        $this->assertInstanceOf(Coin::class, $coin, 'The returned object should be an instance of Coin.');

        $this->assertEquals('American Gold Eagle', (string) $coin->name);
        $this->assertEquals('The American Gold Eagle is a popular investment coin.', (string) $coin->description);
        $this->assertEquals('2000.00', $coin->purchasePrice->getAmount());
        $this->assertEquals('USD', $coin->purchasePrice->getCurrency());
        $this->assertEquals('gold', $coin->metal->value);
        $this->assertEquals(31.1035, $coin->weight);
        $this->assertEquals(0.9167, $coin->purity);
        $this->assertEquals(50, $coin->nominal);
        $this->assertEquals('usa', $coin->country->value);
        $this->assertEquals(2023, $coin->year);
        $this->assertEquals('2023-12-01T00:15:00+02:00', (string) $coin->purchaseDate);
    }
}
