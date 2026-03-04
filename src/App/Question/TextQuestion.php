<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\App\Question;

use RuntimeException;
use Symfony\Component\Console\Question\Question;
use thofman\KnowledgeBase\Domain\Question\Sanitization\StringSanitizer;
use thofman\KnowledgeBase\Domain\Question\Validation\Validator;

final readonly class TextQuestion implements ArticleQuestion
{
    public function __construct(
        private string $question,
        private Validator $validator,
        private StringSanitizer $stringSanitizer,
    ) {
    }

    public function getQuestion(): Question
    {
        return new Question($this->question, '')
            ->setValidator(
                function (string $value): string {
                    $validationResult = $this->validator->validate($value);
                    if (!$validationResult->isValid) {
                        throw new RuntimeException($validationResult->validationErrorMessage);
                    }

                    return $this->stringSanitizer->sanitize($validationResult->value);
                }
            )
        ;
    }
}
