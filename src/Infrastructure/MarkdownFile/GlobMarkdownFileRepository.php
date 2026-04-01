<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Infrastructure\MarkdownFile;

use SplFileInfo;
use thofman\KnowledgeBase\Domain\MarkdownFile\Index\IndexMarkdownFile;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFile;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFileCollection;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFileRepository;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFilesDirectory;

final readonly class GlobMarkdownFileRepository implements MarkdownFileRepository
{
    public function __construct(
        private IndexMarkdownFile $indexMarkdownFile,
    ) {
    }

    public function getMarkdownFileCollection(MarkdownFilesDirectory $markdownFilesDirectory): MarkdownFileCollection
    {
        $allMdFiles = glob($markdownFilesDirectory->getPathname() . '/*.md');
        $mdFilesWithoutIndex = array_filter(
            $allMdFiles,
            fn(string $file): bool => !str_ends_with($file, $this->indexMarkdownFile->getFilename()),
        );
        return new MarkdownFileCollection(
            ...array_map(
                static fn(string $file): MarkdownFile => new MarkdownFile(new SplFileInfo($file)),
                $mdFilesWithoutIndex,
            )
        );
    }
}
