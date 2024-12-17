<?php

declare(strict_types=1);

namespace Domain\Common\ValueObject;

interface Money
{
    public function getAmount(): string;
    public function getCurrency(): string;
    public function add(self $other): Money;
    public function subtract(self $other): Money;
    public function greaterThan(self $other): bool;
    public function lessThan(self $other): bool;
    public function equals(self $other): bool;
    public function sameCurrency(self $other): bool;
    public function multiply(float $multiplier): Money;
    public function convertTo(string $targetCurrency, float $conversionRate): Money;
}
