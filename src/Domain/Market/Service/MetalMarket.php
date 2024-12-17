<?php

declare(strict_types=1);

namespace Domain\Market\Service;

use Domain\Coin\Model\Coin;
use Domain\Common\ValueObject\Money;
use Domain\Market\Repository\MarketRepositoryInterface;

final readonly class MetalMarket
{
    public function __construct(private MarketRepositoryInterface $repository)
    {
    }

    public function evaluate(Coin $coin): Money
    {
        $pricePerGram = $this->repository->metalPricePerGram(
            $coin->metal,
            $coin->karats(),
            $coin->purchasePrice->getCurrency()
        );

        return $pricePerGram->multiply($coin->pureMetalWeight());
    }
}
