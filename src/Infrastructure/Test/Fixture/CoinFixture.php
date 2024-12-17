<?php

declare(strict_types=1);

namespace Infrastructure\Test\Fixture;

use Domain\Coin\Model\Coin;
use Domain\Common\Enum\Country;
use Domain\Common\Enum\Metal;
use Domain\Common\Service\Money\CharInitializerServiceInterface;
use Domain\Common\Service\Money\DateTimeInitializerServiceInterface;
use Domain\Common\Service\Money\MoneyInitializerServiceInterface;
use Domain\Common\ValueObject\Id;
use Generator;

final readonly class CoinFixture
{
    public function __construct(
        private CharInitializerServiceInterface $charInitializerService,
        private MoneyInitializerServiceInterface $moneyInitializerService,
        private DateTimeInitializerServiceInterface $dateTimeInitializerService,
    ) {
    }

    public function items(): Generator
    {
        yield $this->mapleLeaf();
        yield $this->eagle();
        yield $this->britannia();
    }

    public function eagle(): Coin
    {
        return new Coin(
            id: new Id('01a4bd7c-9f34-4e22-94af-1134ae561f77'),
            name: $this->charInitializerService->create('Golden Eagle'),
            description: $this->charInitializerService->create('A stunning silver coin from the USA'),
            purchasePrice: $this->moneyInitializerService->create(2500, 'USD'),
            metal: Metal::Gold,
            weight: 31.1,
            purity: 999.9,
            nominal: 1,
            country: Country::USA,
            year: 2023,
            purchaseDate: $this->dateTimeInitializerService->create('2023-11-15T14:30:00+02:00'),
        );
    }

    public function mapleLeaf(): Coin
    {
        return new Coin(
            id: new Id('02b7de8f-8e45-5c11-82bc-b38ecf671a55'),
            name: $this->charInitializerService->create('Maple Leaf'),
            description: $this->charInitializerService->create('Iconic Canadian gold coin'),
            purchasePrice: $this->moneyInitializerService->create(1900, 'CAD'),
            metal: Metal::Gold,
            weight: 31.1,
            purity: 999.9,
            nominal: 50,
            country: Country::Australia,
            year: 2022,
            purchaseDate: $this->dateTimeInitializerService->create('2023-10-20T09:45:00+02:00'),
        );
    }

    public function britannia(): Coin
    {
        return new Coin(
            id: new Id('0193ce8c-5e87-7f73-81de-b17ef561d33c'),
            name: $this->charInitializerService->create('Britannia 1/2 oz Gold'),
            description: $this->charInitializerService->create('Gold investment coin'),
            purchasePrice: $this->moneyInitializerService->create(1550, 'EUR'),
            metal: Metal::Gold,
            weight: 15.55,
            purity: 999.9,
            nominal: 50,
            country: Country::UnitedKingdom,
            year: 2024,
            purchaseDate: $this->dateTimeInitializerService->create('2023-12-01T00:15:00+02:00'),
        );
    }
}
