<?php

declare(strict_types=1);

namespace Domain\Common\Service\Money;

use Domain\Common\ValueObject\Id;

interface IdGeneratorInterface
{
    public function generate(): Id;
}
