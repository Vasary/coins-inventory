<?php

declare(strict_types=1);

namespace Presentation\API\HTTP\Coin;

use Application\UseCase\Coin\Place\PlaceCoinUseCase;
use Application\UseCase\Coin\Place\Request\PlaceCoinRequest;
use Infrastructure\Framework\Symfony\HTTP\Request\CoinRequest;
use Infrastructure\Framework\Symfony\Routing\Controller;
use Infrastructure\Framework\Symfony\Routing\Response;
use Infrastructure\Validation\ConstraintsBuilder;
use Infrastructure\Validation\ValidationService;

final class PlaceCoinController extends Controller
{
    private function constraints(ConstraintsBuilder $builder): object
    {
        return $builder
            ->notBlank('country')
            ->choice('country', 'unitedKingdom', 'usa', 'canada', 'australia')
            ->notBlank('description')
            ->length('description', max: 1000)
            ->notBlank('metal')
            ->choice('metal', 'Gold')
            ->notBlank('name')
            ->length('name', max: 255)
            ->notBlank('nominal')
            ->positiveOrZero('nominal')
            ->notBlank('purchaseCurrency')
            ->currency('purchaseCurrency')
            ->notBlank('purchaseDate')
            ->date('purchaseDate')
            ->notBlank('purchasePrice')
            ->positive('purchasePrice')
            ->notBlank('purity')
            ->range('purity', min: 91.0, max: 99.999)
            ->notBlank('weight')
            ->positive('weight')
            ->notBlank('year')
            ->range('year', min: 1990, max: 2050)
            ->build();
    }

    public function __invoke(
        PlaceCoinUseCase $useCase,
        CoinRequest $coinRequest,
        ValidationService $validator,
        ConstraintsBuilder $constraintsBuilder,
    ): Response {
        $data = json_decode($coinRequest->getContent(), true);
        $violations = $validator->validate($data, $this->constraints($constraintsBuilder));

        if (null !== $violations) {
            return new Response($violations, Response::BAD_REQUEST);
        }

        $coin = $useCase(
            new PlaceCoinRequest(
                name: $data['name'],
                description: $data['description'],
                purchasePrice: (int)$data['purchasePrice'],
                purchaseCurrency: $data['purchaseCurrency'],
                metal: $data['metal'],
                weight: (float)$data['weight'],
                purity: (float)$data['purity'],
                nominal: (int)$data['nominal'],
                country: $data['country'],
                year: (int)$data['year'],
                purchaseDate: $data['purchaseDate']
            )
        );

        return new Response([$coin], 201);
    }
}
