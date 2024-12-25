<?php

declare(strict_types=1);

namespace Infrastructure\Framework\Symfony;

use Infrastructure\Framework\Symfony\HTTP\Request\CoinInventoryRequestFactory;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function __construct(string $environment, bool $debug)
    {
        parent::__construct($environment, $debug);

        CoinInventoryRequestFactory::register();
    }
}
