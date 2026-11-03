<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Presentation\Cli\Question;

use Symfony\Component\Console\Question\Question;

interface ArticleQuestion
{
    public function getQuestion(): Question;
}
