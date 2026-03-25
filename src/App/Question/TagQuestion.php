<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\App\Question;

use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use thofman\KnowledgeBase\Domain\Question\Tag;

final readonly class TagQuestion implements ArticleQuestion
{
    public function getQuestion(): Question
    {
        return new ChoiceQuestion(
            sprintf('Select tag (defaults to %s)', Tag::AGILE->value),
            $this->getQuestionChoicesForTag(),
            Tag::AGILE->value,
        );
    }

    /**
     * @return array<string, string>
     */
    private function getQuestionChoicesForTag(): array
    {
        $choices = [];
        foreach (Tag::cases() as $case) {
            $choices[$case->value] = $case->value;
        }
        return $choices;
    }
}
