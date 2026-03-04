<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\Question\Validation;

final readonly class ValidationResult
{
    public static function valid(): self
    {
        return new self(
            isValid: true,
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
        public string $validationErrorMessage = '',
    ) {
    }
}
