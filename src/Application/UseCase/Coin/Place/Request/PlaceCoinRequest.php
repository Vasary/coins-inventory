<?php

declare(strict_types=1);

namespace Application\UseCase\Coin\Place\Request;

use ArrayIterator;
use IteratorAggregate;
use LogicException;
use Traversable;

final readonly class PlaceCoinRequest implements IteratorAggregate
{
    public function __construct(
        private string $name,
        private string $description,
        private int $purchasePrice,
        private string $purchaseCurrency,
        private string $metal,
        private float $weight,
        private float $purity,
        private int $nominal,
        private string $country,
        private int $year,
        private string $purchaseDate,
    ) {
    }

    /**
     * @throws LogicException
     */
    public function getSignature(): string
    {
        return sha1(
            implode('+', array_map(fn (mixed $attribute) => (string) $attribute, [...$this->getIterator()]))
        );
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator([
            $this->name,
            $this->description,
            $this->purchasePrice,
            $this->purchaseCurrency,
            $this->metal,
            $this->weight,
            $this->purity,
            $this->nominal,
            $this->country,
            $this->year,
            $this->purchaseDate,
        ]);
    }
}
