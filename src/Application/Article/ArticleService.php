<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Application\Article;

use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFile;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFilesDirectory;
use thofman\KnowledgeBase\Domain\MarkdownFile\Template\TemplateMarkdownFile;
use thofman\KnowledgeBase\Domain\Question\Tag;

final readonly class ArticleService
{
    public function __construct(
        private NewMarkdownFileService $newMarkdownFileService,
        private ReplaceTemplateService $replaceTemplateService,
    ) {
    }

    public function addArticle(
        MarkdownFilesDirectory $markdownFilesDirectory,
        TemplateMarkdownFile $templateMarkdownFile,
        string $author,
        string $title,
        string $url,
        Tag $tag,
        string $description,
    ): MarkdownFile {
        return $this->replaceTemplateService->replaceTemplate(
            $templateMarkdownFile,
            $this->newMarkdownFileService->getNewMarkdownFile(
                $markdownFilesDirectory,
                $author,
                $title
            ),
            $author,
            $title,
            $url,
            $tag,
            $description
        );
    }
}
