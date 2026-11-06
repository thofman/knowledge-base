<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Application\Article;

use SplFileInfo;
use thofman\KnowledgeBase\Application\IoHelper;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFile;
use thofman\KnowledgeBase\Domain\MarkdownFile\Template\NewMarkdownFile;
use thofman\KnowledgeBase\Domain\MarkdownFile\Template\TemplateMarkdownFile;
use thofman\KnowledgeBase\Domain\Question\Tag;

final readonly class ReplaceTemplateService
{
    public function __construct(
        private IoHelper $ioHelper,
    ) {
    }

    public function replaceTemplate(
        TemplateMarkdownFile $templateMarkdownFile,
        NewMarkdownFile $newMarkdownFile,
        string $author,
        string $title,
        string $url,
        Tag $tag,
        string $description,
    ): MarkdownFile {
        $this->ioHelper->copy($templateMarkdownFile->getPathname(), $newMarkdownFile->getPathname());
        $fileContents = $this->ioHelper->read($newMarkdownFile->getPathname());
        $fileContents1 = preg_replace('/##author##/', $author, $fileContents);
        $fileContents2 = preg_replace('/##title##/', $title, $fileContents1);
        $fileContents3 = preg_replace('/##url##/', $url, $fileContents2);
        $fileContents4 = preg_replace('/##tag##/', $tag->value, $fileContents3);
        $fileContents5 = preg_replace('/##description##/', $description, $fileContents4);
        $this->ioHelper->write($newMarkdownFile->getPathname(), $fileContents5);
        return new MarkdownFile(new SplFileInfo($newMarkdownFile->getPathname()));
    }
}
