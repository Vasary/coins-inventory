<?php

declare(strict_types=1);

namespace Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Step\Given;
use Domain\Coin\Repository\RepositoryInterface;
use Infrastructure\Test\Fixture\CoinFixture;
use PHPUnit\Framework\ExpectationFailedException;

final class CoinContext implements Context
{
    public function __construct(private RepositoryInterface $repository, private CoinFixture $coinFixture)
    {
    }

    #[Given('i have a(n) :coin coin')]
    public function iHaveACoins(string $coin): void
    {
        if (!method_exists($this->coinFixture, $coin)) {
            throw new ExpectationFailedException(sprintf('Coin %s does not exist', $coin));
        }

        $coin = $this->coinFixture->$coin();

        $this->repository->add($coin);
    }
}
