<?php

declare(strict_types=1);

namespace Infrastructure\Money\Service;

use Domain\Common\Service\Money\MoneyInitializerServiceInterface;
use Domain\Common\ValueObject\Money;
use Infrastructure\Money\ValueObject\Money as InfrastructureMoney;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\MoneyFormatter;

final class MoneyInitializerService implements MoneyInitializerServiceInterface
{
    public function create(int $amount, string $currency): Money
    {
        return new InfrastructureMoney($amount, $currency, $this->getMoneyFormatter());
    }

    private function getMoneyFormatter(): MoneyFormatter
    {
        return new DecimalMoneyFormatter(new ISOCurrencies());
    }
}
