<?php

declare(strict_types=1);

namespace Infrastructure\Test;

use Predis\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class TestCase extends KernelTestCase
{
    protected function setUp(): void
    {
        $this->getContainer()->get(Client::class)->flushAll();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->getContainer()->get(Client::class)->flushAll();

        restore_exception_handler();
    }
}
