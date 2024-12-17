<?php

declare(strict_types=1);

namespace Application\UseCase\Coin\Place;

use Application\Service\LockService\LockServiceInterface;
use Application\UseCase\Coin\Place\Request\PlaceCoinRequest;
use Domain\Coin\Factory\CoinFactory;
use Domain\Coin\Model\Coin;
use Domain\Coin\Repository\RepositoryInterface;

final readonly class PlaceCoinUseCase
{
    public function __construct(
        private CoinFactory $factory,
        private RepositoryInterface $repository,
        private LockServiceInterface $lockService,
    ) {
    }

    public function __invoke(PlaceCoinRequest $request): Coin
    {
        return $this->lockService->runExclusive(
            function () use ($request): Coin {
                $coin = $this->factory->create(...$request);

                $this->repository->add($coin);

                return $coin;
            },
            $request->getSignature()
        );
    }
}
