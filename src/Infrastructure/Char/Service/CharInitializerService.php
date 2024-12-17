<?php

declare(strict_types=1);

namespace Infrastructure\Char\Service;

use Domain\Common\Service\Money\CharInitializerServiceInterface;
use Domain\Common\ValueObject\Char as DomainChar;
use Infrastructure\Char\ValueObject\Char;

final class CharInitializerService implements CharInitializerServiceInterface
{
    public function create(string $text): DomainChar
    {
        return new Char($text);
    }
}
