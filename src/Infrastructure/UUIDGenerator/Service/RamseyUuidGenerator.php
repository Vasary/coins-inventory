<?php

declare(strict_types=1);

namespace Infrastructure\UUIDGenerator\Service;

use Domain\Common\Service\Money\IdGeneratorInterface;
use Domain\Common\ValueObject\Id;
use Ramsey\Uuid\Uuid;

final class RamseyUuidGenerator implements IdGeneratorInterface
{
    public function generate(): Id
    {
        return new Id(Uuid::uuid7()->toString());
    }
}
