<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\FrontMatter;

use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFile;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFileCollection;

interface FrontMatterRepository
{
    public function getFrontMatter(MarkdownFile $markdownFile): FrontMatter;

    public function getFrontMatterCollection(MarkdownFileCollection $markdownFileCollection): FrontMatterCollection;
}
