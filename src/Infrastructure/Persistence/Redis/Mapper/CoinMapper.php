<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Redis\Mapper;

use Domain\Coin\Model\Coin as DomainCoin;
use Domain\Common\Enum\Country;
use Domain\Common\Enum\Metal;
use Domain\Common\ValueObject\Id;
use Infrastructure\Char\Service\CharInitializerService;
use Infrastructure\DateTime\Service\DateTimeInitializerService;
use Infrastructure\Money\Service\MoneyInitializerService;
use Infrastructure\Persistence\Redis\Entity\Coin as EntityCoin;

final readonly class CoinMapper
{
    public function __construct(
        private MoneyInitializerService $moneyInitializer,
        private CharInitializerService $charInitializer,
        private DateTimeInitializerService $dateTimeInitializer,
    ) {
    }

    public function toEntity(DomainCoin $coin): EntityCoin
    {
        $now = new DateTimeInitializerService()->now();

        return new EntityCoin(
            id: (string) $coin->id,
            name: (string) $coin->name,
            description: (string) $coin->description,
            purchasePrice: $coin->purchasePrice->getAmount(),
            purchaseCurrency: $coin->purchasePrice->getCurrency(),
            metal: $coin->metal->value,
            weight: $coin->weight,
            purity: $coin->purity,
            nominal: $coin->nominal,
            country: $coin->country->value,
            year: $coin->year,
            purchaseDate: (string) $coin->purchaseDate,
            createdAt: (string) $now,
        );
    }

    public function fromSerialized(string $serializedData): EntityCoin
    {
        $decodedData = json_decode($serializedData, true);

        return new EntityCoin(
            id: $decodedData['id'],
            name: $decodedData['name'],
            description: $decodedData['description'],
            purchasePrice: $decodedData['purchase_price'],
            purchaseCurrency: $decodedData['purchase_currency'],
            metal: $decodedData['metal'],
            weight: $decodedData['weight'],
            purity: $decodedData['purity'],
            nominal: $decodedData['nominal'],
            country: $decodedData['country'],
            year: $decodedData['year'],
            purchaseDate: $decodedData['purchase_date'],
            createdAt: $decodedData['created_at'],
        );
    }

    public function toDomain(EntityCoin $coin): DomainCoin
    {
        return new DomainCoin(
            id: new Id($coin->id),
            name: $this->charInitializer->create($coin->name),
            description: $this->charInitializer->create($coin->description),
            purchasePrice: $this->moneyInitializer->create((int) $coin->purchasePrice * 100, $coin->purchaseCurrency),
            metal: Metal::tryFrom($coin->metal),
            weight: $coin->weight,
            purity: $coin->purity,
            nominal: $coin->nominal,
            country: Country::tryFrom($coin->country),
            year: $coin->year,
            purchaseDate: $this->dateTimeInitializer->create($coin->purchaseDate),
        );
    }
}
