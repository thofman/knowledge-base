<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\MarkdownFile;

interface MarkdownFileRepository
{
    public function getMarkdownFileCollection(MarkdownFilesDirectory $markdownFilesDirectory): MarkdownFileCollection;
}
