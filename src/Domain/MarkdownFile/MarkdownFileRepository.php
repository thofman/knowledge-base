<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\MarkdownFile;

interface MarkdownFileRepository
{
    /**
     * @return list<MarkdownFile>
     */
    public function getMarkdownFiles(MarkdownFilesDirectory $markdownFilesDirectory): array;
}
