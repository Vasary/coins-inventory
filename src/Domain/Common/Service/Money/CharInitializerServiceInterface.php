<?php

declare(strict_types=1);

namespace Domain\Common\Service\Money;

use Domain\Common\ValueObject\Char;

interface CharInitializerServiceInterface
{
    public function create(string $text): Char;
}
