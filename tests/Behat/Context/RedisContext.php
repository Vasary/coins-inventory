<?php

declare(strict_types=1);

namespace Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\ScenarioScope;
use Behat\Hook\AfterScenario;
use Behat\Hook\BeforeScenario;
use Predis\ClientInterface;

final readonly class RedisContext implements Context
{
    public function __construct(private ClientInterface $redis)
    {
    }

    #[BeforeScenario]
    #[AfterScenario]
    public function clearRedis(ScenarioScope $scope): void
    {
        $this->redis->flushall();
    }
}
