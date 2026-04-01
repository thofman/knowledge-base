<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Infrastructure\MarkdownFile;

use SplFileInfo;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFile;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFileCollection;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFileRepository;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFilesDirectory;

final class GlobMarkdownFileRepository implements MarkdownFileRepository
{
    public function getMarkdownFileCollection(MarkdownFilesDirectory $markdownFilesDirectory): MarkdownFileCollection
    {
        $allMdFiles = glob($markdownFilesDirectory->getPathname() . '/*.md');
        $mdFilesWithoutIndex = array_filter(
            $allMdFiles,
            static fn(string $file): bool => !str_ends_with($file, '_index.md'),
        );
        return new MarkdownFileCollection(
            ...array_map(
                static fn(string $file): MarkdownFile => new MarkdownFile(new SplFileInfo($file)),
                $mdFilesWithoutIndex,
            )
        );
    }
}
