<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\FrontMatter;

use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFile;

interface FrontMatterRepository
{
    public function getFrontMatter(MarkdownFile $markdownFile): FrontMatter;

    /**
     * @param list<MarkdownFile> $markdownFiles
     * @return list<FrontMatter>
     */
    public function getFrontMatters(array $markdownFiles): array;
}
