<?php

declare(strict_types=1);

namespace Infrastructure\DateTime\ValueObject;

use DateTimeImmutable;
use Domain\Common\ValueObject\DateTime as DomainDateTime;

final readonly class DateTime implements DomainDateTime
{
    public function __construct(private DateTimeImmutable $dateTime)
    {
    }

    public function __toString(): string
    {
        return $this->dateTime->format(DATE_ATOM);
    }
}
