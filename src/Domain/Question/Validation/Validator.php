<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\Question\Validation;

use Symfony\Component\Console\Question\Question;

interface Validator
{
    public function validate(string $value): ValidationResult;
}
