<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\Question\Validation;

interface Validator
{
    public function validate(string $value): ValidationResult;
}
