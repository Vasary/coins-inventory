<?php

declare(strict_types=1);

namespace Domain\Common\ValueObject;

interface Money
{
    public function getAmount(): string;
    public function getCurrency(): string;
    public function multiply(float $multiplier): Money;
}
