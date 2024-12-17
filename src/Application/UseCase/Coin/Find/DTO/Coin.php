<?php

declare(strict_types=1);

namespace Application\UseCase\Coin\Find\DTO;

final class Coin
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public string $purchasePrice,
        public string $purchaseCurrency,
        public string $metal,
        public float $weight,
        public float $purity,
        public int $nominal,
        public string $country,
        public int $year,
        public string $marketValue,
    ) {}
}
