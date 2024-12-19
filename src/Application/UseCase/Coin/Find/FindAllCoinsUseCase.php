<?php

declare(strict_types=1);

namespace Application\UseCase\Coin\Find;

use Application\Service\Serializer\CoinSerializer;
use Domain\Coin\Repository\RepositoryInterface;
use Domain\Market\Service\MetalMarket;
use Generator;

final readonly class FindAllCoinsUseCase
{
    public function __construct(
        private RepositoryInterface $repository,
        private MetalMarket $market,
        private CoinSerializer $serializer,
    ) {
    }

    public function __invoke(): Generator
    {
        foreach ($this->repository->finaAll() as $coin) {
            yield $this->serializer->serialize($coin, $this->market->evaluate($coin));
        }
    }
}
