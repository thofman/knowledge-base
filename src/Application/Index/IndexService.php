<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Application\Index;

use thofman\KnowledgeBase\Domain\FrontMatter\FrontMatterRepository;
use thofman\KnowledgeBase\Domain\MarkdownFile\Index\IndexMarkdownFile;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFileRepository;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFilesDirectory;

final readonly class IndexService
{
    public function __construct(
        private MarkdownFileRepository $markdownFileRepository,
        private FrontMatterRepository $frontMatterRepository,
    ) {
    }

    public function reindexIndexMarkdownFile(
        MarkdownFilesDirectory $markdownFilesDirectory,
        IndexMarkdownFile $indexMarkdownFile,
    ): void {
        $frontMatterCollection = $this->frontMatterRepository->getFrontMatterCollection(
            $this->markdownFileRepository->getMarkdownFileCollection(
                $markdownFilesDirectory,
                $indexMarkdownFile,
            )
        );
        $indexMarkdownFile->reindexAndReplaceContents(
            $frontMatterCollection->getSortedAscendingOnTagAuthorAndTitleCollection()
        );
    }
}
