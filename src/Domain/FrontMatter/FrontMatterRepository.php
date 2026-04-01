<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\FrontMatter;

use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFileCollection;

interface FrontMatterRepository
{
    public function getFrontMatterCollection(MarkdownFileCollection $markdownFileCollection): FrontMatterCollection;
}
