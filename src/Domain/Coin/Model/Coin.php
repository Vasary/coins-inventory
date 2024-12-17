<?php

declare(strict_types=1);

namespace Domain\Coin\Model;

use Domain\Common\Enum\Country;
use Domain\Common\Enum\Metal;
use Domain\Common\ValueObject\Char;
use Domain\Common\ValueObject\DateTime;
use Domain\Common\ValueObject\Id;
use Domain\Common\ValueObject\Money;

final readonly class Coin
{
    public function __construct(
        public Id $id,
        public Char $name,
        public Char $description,
        public Money $purchasePrice,
        public Metal $metal,
        public float $weight,
        public float $purity,
        public int $nominal,
        public Country $country,
        public int $year,
        public DateTime $purchaseDate
    ) {
    }

    public function karats(): int
    {
        return (int) round($this->pureMetalWeight() / $this->weight * 24);
    }

    public function pureMetalWeight(): float
    {
        return $this->weight * $this->purity / 1000;
    }

    public function metalPrice(Money $pricePerGram): Money
    {
        return $pricePerGram->multiply($this->pureMetalWeight());
    }
}
