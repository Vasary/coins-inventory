<?php

declare(strict_types=1);

namespace Presentation\API\HTTP\Coin;

use Application\Service\Serializer\DTO\Coin;
use Application\UseCase\Coin\Find\FindAllCoinsUseCase;
use Domain\Common\Enum\Country;
use Domain\Common\Enum\Metal;
use Generator;
use Infrastructure\Framework\Symfony\Routing\JsonStreamedResponse;
use Infrastructure\Test\TestCase;

final class FindCoinsControllerTest extends TestCase
{
    public function testShouldSuccessfullyFindCoins(): void
    {
        /** @var FindCoinsController $controller */
        $controller = $this->getContainer()->get(FindCoinsController::class);

        /** @var FindAllCoinsUseCase $useCaseMock */
        $useCaseMock = $this->createMock(FindAllCoinsUseCase::class);

        $useCaseMock
            ->expects($this->once())
            ->method('__invoke')
            ->willReturnCallback(
                fn (): Generator => yield new Coin(
                    'id',
                    'name',
                    'description',
                    '1000',
                    'EUR',
                    Metal::Gold->value,
                    10,
                    99.999,
                    25,
                    Country::USA->value,
                    2015,
                    '10',
                    24,
                    25.1,
                    '2023-12-01T00:15:00+02:00'
                )
            );

        $response = $controller->__invoke($useCaseMock);

        $stream = $this->catchStream($response);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertInstanceOf(JsonStreamedResponse::class, $response);
        $this->assertJson($stream);
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/response/find_all_coins.json', $stream);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadCoinsFixture();
    }

    private function catchStream(JsonStreamedResponse $response): string
    {
        ob_start();

        $response->sendContent();

        return ob_get_clean();
    }
}
