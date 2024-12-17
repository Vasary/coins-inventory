<?php

declare(strict_types=1);

namespace Domain\Coin\Repository;

use Domain\Coin\Model\Coin;
use Generator;

interface RepositoryInterface
{
    public function add(Coin $coin): void;

    /**
     * @return Generator<Coin>
     */
    public function finaAll(): Generator;

    public function remove(Coin $coin): void;
}
