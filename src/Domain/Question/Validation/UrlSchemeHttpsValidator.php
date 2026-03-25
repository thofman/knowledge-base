<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\Question\Validation;

final readonly class UrlSchemeHttpsValidator implements Validator
{
    public function __construct(
        private UrlValidator $urlValidator,
    ) {
    }

    public function validate(string $value): ValidationResult
    {
        $validationResult = $this->urlValidator->validate($value);
        if (!$validationResult->isValid) {
            return $validationResult;
        }

        if (parse_url($validationResult->value, PHP_URL_SCHEME) !== 'https') {
            return ValidationResult::invalid('URL must be secure (https)');
        }

        return ValidationResult::valid($validationResult->value);
    }
}
