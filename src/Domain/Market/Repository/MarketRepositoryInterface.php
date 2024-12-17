<?php

declare(strict_types=1);

namespace Domain\Market\Repository;

use Domain\Common\Enum\Metal;
use Domain\Common\ValueObject\Money;

interface MarketRepositoryInterface
{
    public function metalPricePerGram(Metal $metal, int $karat, string $currency): Money;
}
