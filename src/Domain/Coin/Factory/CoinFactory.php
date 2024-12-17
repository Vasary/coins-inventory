<?php

declare(strict_types=1);

namespace Domain\Coin\Factory;

use Domain\Coin\Model\Coin;
use Domain\Common\Enum\Country;
use Domain\Common\Enum\Metal;
use Domain\Common\Service\Money\CharInitializerServiceInterface;
use Domain\Common\Service\Money\DateTimeInitializerServiceInterface;
use Domain\Common\Service\Money\IdGeneratorInterface;
use Domain\Common\Service\Money\MoneyInitializerServiceInterface;

final readonly class CoinFactory
{
    public function __construct(
        private CharInitializerServiceInterface $charInitializerService,
        private MoneyInitializerServiceInterface $moneyInitializerService,
        private DateTimeInitializerServiceInterface $dateTimeInitializerService,
        private IdGeneratorInterface $idGenerator,
    ) {
    }

    public function create(
        string $name,
        string $description,
        int $purchasePrice,
        string $purchaseCurrency,
        string $metal,
        float $weight,
        float $purity,
        int $nominal,
        string $country,
        int $year,
        string $purchaseDate
    ): Coin {
        return new Coin(
            $this->idGenerator->generate(),
            $this->charInitializerService->create($name),
            $this->charInitializerService->create($description),
            $this->moneyInitializerService->create($purchasePrice, $purchaseCurrency),
            Metal::tryFrom(strtolower($metal)),
            $weight,
            $purity,
            $nominal,
            Country::tryFrom(strtolower($country)),
            $year,
            $this->dateTimeInitializerService->create($purchaseDate),
        );
    }
}
