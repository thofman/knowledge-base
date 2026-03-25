<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\Question\Validation;

final readonly class ValidationResult
{
    public static function valid(string $value): self
    {
        return new self(
            isValid: true,
            value: $value,
        );
    }

    public static function invalid(string $validationErrorMessage): self
    {
        return new self(
            isValid: false,
            validationErrorMessage: $validationErrorMessage,
        );
    }

    private function __construct(
        public bool $isValid,
        public string $value = '',
        public string $validationErrorMessage = '',
    ) {
    }
}
