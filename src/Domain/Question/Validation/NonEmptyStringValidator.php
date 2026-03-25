<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\Question\Validation;

final readonly class NonEmptyStringValidator implements Validator
{
    public function __construct(
        private string $subject,
    ) {
    }

    public function validate(string $value): ValidationResult
    {
        $trimmedValue = trim($value);
        if ($trimmedValue === '') {
            return ValidationResult::invalid(sprintf('%s cannot be empty', $this->subject));
        }

        return ValidationResult::valid($trimmedValue);
    }
}
