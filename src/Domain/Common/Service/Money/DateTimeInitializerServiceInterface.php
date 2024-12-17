<?php

declare(strict_types=1);

namespace Domain\Common\Service\Money;

use Domain\Common\ValueObject\DateTime;

interface DateTimeInitializerServiceInterface
{
    public function create(string $dateString): DateTime;
    public function now(): DateTime;
}
