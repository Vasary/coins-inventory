<?php

declare(strict_types=1);

namespace Infrastructure\Char\ValueObject;

use Domain\Common\ValueObject\Char as DomainChar;
use Symfony\Component\String\UnicodeString;
use function Symfony\Component\String\u;

final class Char implements DomainChar
{
    private UnicodeString $value;

    public function __construct(string $value)
    {
        $this->value = u($value);
    }

    public function __toString(): string
    {
        return $this->value->toString();
    }
}
