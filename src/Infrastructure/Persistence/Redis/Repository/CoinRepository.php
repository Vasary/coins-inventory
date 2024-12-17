<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Redis\Repository;

use Domain\Coin\Model\Coin as DomainCoin;
use Domain\Coin\Repository\RepositoryInterface;
use Infrastructure\Persistence\Redis\DAO\Coin as CoinDAO;
use Infrastructure\Persistence\Redis\Mapper\CoinMapper;
use Generator;

final readonly class CoinRepository implements RepositoryInterface
{
    public function __construct(private CoinDAO $dao, private CoinMapper $mapper)
    {
    }

    public function add(DomainCoin $coin): void
    {
        $this->dao->saveOrReplace($this->mapper->toEntity($coin));
    }

    /**
     * @inheritDoc
     */
    public function finaAll(): Generator
    {
        foreach ($this->dao->findAll() as $coin) {
            yield $this->mapper->toDomain($coin);
        }
    }

    public function remove(DomainCoin $coin): void
    {
        $this->dao->remove($this->mapper->toEntity($coin));
    }
}
