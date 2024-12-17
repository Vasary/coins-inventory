<?php

declare(strict_types=1);

namespace Infrastructure\Money\ValueObject;

use Domain\Common\ValueObject\Money as DomainMoneyInterface;
use Money\Currency;
use Money\Money as ExternalMoney;
use Money\MoneyFormatter;

final readonly class Money implements DomainMoneyInterface
{
    private ExternalMoney $money;

    public function __construct(string|float|int $amount, string $currency, private MoneyFormatter $formatter)
    {
        $this->money = new ExternalMoney($amount, new Currency($currency));
    }

    public function getAmount(): string
    {
        return $this->formatter->format($this->money);
    }

    public function getCurrency(): string
    {
        return $this->money->getCurrency()->getCode();
    }

    public function add(DomainMoneyInterface $other): DomainMoneyInterface
    {
        $newMoney = $this->money->add($other->money);
        return new self($newMoney->getAmount(), $newMoney->getCurrency()->getCode(), $this->formatter);
    }

    public function subtract(DomainMoneyInterface $other): DomainMoneyInterface
    {
        $newMoney = $this->money->subtract($other->money);
        return new self($newMoney->getAmount(), $newMoney->getCurrency()->getCode(), $this->formatter);
    }

    public function greaterThan(DomainMoneyInterface $other): bool
    {
        return $this->money->greaterThan($other->money);
    }

    public function lessThan(DomainMoneyInterface $other): bool
    {
        return $this->money->lessThan($other->money);
    }

    public function equals(DomainMoneyInterface $other): bool
    {
        return $this->money->equals($other->money);
    }

    public function sameCurrency(DomainMoneyInterface $other): bool
    {
        return $this->money->getCurrency()->equals($other->money->getCurrency());
    }

    public function multiply(float $multiplier): DomainMoneyInterface
    {
        $newMoney = $this->money->multiply($multiplier);
        return new self($newMoney->getAmount(), $newMoney->getCurrency()->getCode(), $this->formatter);
    }

    public function convertTo(string $targetCurrency, float $conversionRate): DomainMoneyInterface
    {
        $convertedAmount = $this->money->getAmount() * $conversionRate;
        return new self($convertedAmount, $targetCurrency, $this->formatter);
    }
}
