<?php

declare(strict_types=1);

namespace Application\UseCase\Coin\RestoreInventory;

use Application\UseCase\Coin\RestoreInventory\Data\Inventory;
use Domain\Coin\Repository\RepositoryInterface;

final readonly class RestoreInventoryUseCase
{
    public function __construct(private Inventory $inventory, private RepositoryInterface $repository)
    {
    }

    public function execute(): void
    {
        foreach ($this->repository->finaAll() as $coin) {
            $this->repository->remove($coin);
        }

        foreach ($this->inventory->get() as $coin) {
            $this->repository->add($coin);
        }
    }
}
