<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\Question\Validation;

final readonly class CompositeValidator implements Validator
{
    /**
     * @param list<Validator> $validators
     */
    public function __construct(
        private array $validators,
    ) {
    }

    public function validate(string $value): ValidationResult
    {
        $validationResult = ValidationResult::valid($value);
        foreach ($this->validators as $validator) {
            $validationResult = $validator->validate($validationResult->value);
            if (!$validationResult->isValid) {
                return $validationResult;
            }
        }
        return $validationResult;
    }
}
