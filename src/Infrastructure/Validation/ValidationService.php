<?php

declare(strict_types=1);

namespace Infrastructure\Validation;

use Generator;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class ValidationService
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function validate(array $content, Collection $constraints): ?Generator
    {
        $violations = $this->validator->validate($content, $constraints);

        if (count($violations) > 0) {
            return $this->createValidationErrorResponse($violations);
        }

        return null;
    }

    private function createValidationErrorResponse(iterable $violations): Generator
    {
        foreach ($violations as $violation) {
            yield [
                'field' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
        }
    }
}
