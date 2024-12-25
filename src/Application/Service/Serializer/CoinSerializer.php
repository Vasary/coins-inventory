<?php

declare(strict_types=1);

namespace Application\Service\Serializer;

use Application\Service\Serializer\DTO\Coin;
use Domain\Coin\Model\Coin as DomainCoin;
use Domain\Common\ValueObject\Money;

final class CoinSerializer
{
    public function serialize(DomainCoin $coin, ?Money $marketValue = null): Coin
    {
        return new Coin(
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
            marketMetalPriceValue: $marketValue?->getAmount() ?? '0.00',
            karats: $coin->karats(),
            pureMetalWeight: $coin->pureMetalWeight(),
            purchaseDate: (string) $coin->purchaseDate,
        );
    }
}
