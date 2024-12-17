<?php

declare(strict_types=1);

namespace Infrastructure\DateTime\Service;

use Carbon\Carbon;
use Domain\Common\Service\Money\DateTimeInitializerServiceInterface;
use Domain\Common\ValueObject\DateTime as DomainDateTime;
use Infrastructure\DateTime\ValueObject\DateTime;

final class DateTimeInitializerService implements DateTimeInitializerServiceInterface
{
    public function create(string $dateString): DomainDateTime
    {
        return new DateTime(Carbon::parse($dateString)->toDateTimeImmutable());
    }

    public function now(): DomainDateTime
    {
        return new DateTime(Carbon::now()->toDateTimeImmutable());
    }
}
