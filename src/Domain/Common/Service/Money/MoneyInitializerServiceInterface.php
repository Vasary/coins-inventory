<?php

declare(strict_types=1);

namespace Domain\Common\Service\Money;

use Domain\Common\ValueObject\Money;

interface MoneyInitializerServiceInterface
{
    public function create(int $amount, string $currency): Money;
}
