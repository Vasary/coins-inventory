<?php

declare(strict_types=1);

namespace Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;
use Coduo\PHPMatcher\PHPMatcher;
use PHPUnit\Framework\ExpectationFailedException;

final class PlaceCoinContext extends MinkContext implements Context
{
    private ?string $requestPayload = null;

    public function __construct(private readonly PHPMatcher $matcher)
    {
    }

    #[Given('i have a coin creation request with the following details:')]
    public function iHaveACoinCreationRequestWithTheFollowingDetails(TableNode $table): void
    {
        $data = [];
        foreach ($table->getRowsHash() as $key => $value) {
            if (is_numeric($value)) {
                $data[$key] = str_contains($value, '.') ? (float)$value : (int)$value;
            } else {
                $data[$key] = $value;
            }
        }

        $this->requestPayload = json_encode($data);
    }

    #[When('I send a :method request to :path')]
    public function iSendARequestTo(string $method, string $path): void
    {
        $this->getSession()->getDriver()->getClient()->request(
            $method,
            $path,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $this->requestPayload
        );
    }

    #[Then('the response should contain the following details, and the fields :forceStringFields should be strings:')]
    public function theResponseShouldMatchTheFollowingStructure(string $forceStringFields, TableNode $table): void
    {
        $responseData = json_decode($this->getSession()->getPage()->getContent(), true);
        $expectedTable = $table->getRowsHash();

        $stringFields = array_map('trim', explode(',', $forceStringFields));

        array_walk_recursive($expectedTable, function (&$value, $key) use ($stringFields): void {
            if (!in_array($key, $stringFields, true) && is_numeric($value)) {
                $value = str_contains($value, '.') ? (float)$value : (int)$value;
            }
        });

        $result = $this->matcher->match($responseData, $expectedTable);

        if (!$result) {
            throw new ExpectationFailedException(
                sprintf(
                    "Response does not match expected structure.\n\nExpected:\n%s\n\nActual:\n%s\n\nMatcher Error: %s",
                    json_encode($expectedTable, JSON_PRETTY_PRINT),
                    json_encode($responseData, JSON_PRETTY_PRINT),
                    $this->matcher->error()
                )
            );
        }
    }

    #[Then('the response content should be equal the following data:')]
    public function theResponseContentShouldEqualTo(string $expectedResponse): void
    {
        $responseData = json_decode($this->getSession()->getPage()->getContent(), true);
        $expectedResponse = json_decode($expectedResponse, true, JSON_THROW_ON_ERROR);

        $result = $this->matcher->match($responseData, $expectedResponse);

        if (!$result) {
            throw new ExpectationFailedException(
                sprintf(
                    "Response does not match expected structure.\n\nExpected:\n%s\n\nActual:\n%s\n\nMatcher Error: %s",
                    json_encode($expectedResponse, JSON_PRETTY_PRINT),
                    json_encode($responseData, JSON_PRETTY_PRINT),
                    $this->matcher->error()
                )
            );
        }
    }
}
