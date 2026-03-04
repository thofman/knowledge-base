<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\Question\Validation;

final readonly class AlwaysValidValidator implements Validator
{
    public function validate(string $value): ValidationResult
    {
        return ValidationResult::valid($value);
    }
}
