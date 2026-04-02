<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\MarkdownFile;

use thofman\KnowledgeBase\Domain\MarkdownFile\Index\IndexMarkdownFile;

interface MarkdownFileRepository
{
    public function getMarkdownFileCollection(
        MarkdownFilesDirectory $markdownFilesDirectory,
        IndexMarkdownFile $indexMarkdownFile,
    ): MarkdownFileCollection;
}
