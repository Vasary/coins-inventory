<?php

declare(strict_types=1);

namespace Application\Service\LockService;

use Closure;
use Exception;

interface LockServiceInterface
{
    /**
     * @throws Exception
     */
    public function runExclusive(Closure $closure, string $key): mixed;
}
