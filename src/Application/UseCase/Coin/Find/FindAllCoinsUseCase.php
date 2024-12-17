<?php

declare(strict_types=1);

namespace Application\UseCase\Coin\Find;

use Application\UseCase\Coin\Find\DTO\Coin;
use Domain\Coin\Repository\RepositoryInterface;
use Domain\Market\Service\MetalMarket;
use Generator;

final readonly class FindAllCoinsUseCase
{
    public function __construct(private RepositoryInterface $repository, private MetalMarket $market)
    {
    }

    public function __invoke(): Generator
    {
        foreach ($this->repository->finaAll() as $coin) {
            $marketValue = $this->market->evaluate($coin);

            yield new Coin(
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
                marketValue: $marketValue->getAmount(),
            );
        }
    }
}
