<?php

declare(strict_types=1);

namespace Domain\Common\ValueObject;

use Stringable;

final readonly class Id implements Stringable
{
    public function __construct(private string $id)
    {
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
