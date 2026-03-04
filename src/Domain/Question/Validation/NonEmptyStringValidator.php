<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\Question\Validation;

final readonly class NonEmptyStringValidator implements Validator
{
    public function validate(string $value): ValidationResult
    {
        if (trim($value) === '') {
            return ValidationResult::invalid('The value cannot be empty');
        }

        return ValidationResult::valid();
    }
}
