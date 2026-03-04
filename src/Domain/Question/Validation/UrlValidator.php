<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\Question\Validation;

final readonly class UrlValidator implements Validator
{
    public function validate(string $value): ValidationResult
    {
        $trimmedValue = trim($value);
        if (!filter_var($trimmedValue, FILTER_VALIDATE_URL)) {
            return ValidationResult::invalid('Value is not a URL');
        }

        return ValidationResult::valid($trimmedValue);
    }
}
