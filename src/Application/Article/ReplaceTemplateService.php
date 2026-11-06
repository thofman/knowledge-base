<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Application\Article;

use SplFileInfo;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFile;
use thofman\KnowledgeBase\Domain\MarkdownFile\Template\NewMarkdownFile;
use thofman\KnowledgeBase\Domain\MarkdownFile\Template\TemplateMarkdownFile;
use thofman\KnowledgeBase\Domain\Question\Tag;

final readonly class ReplaceTemplateService
{
    public function replaceTemplate(
        TemplateMarkdownFile $templateMarkdownFile,
        NewMarkdownFile $newMarkdownFile,
        string $author,
        string $title,
        string $url,
        Tag $tag,
        string $description,
    ): MarkdownFile {
        copy($templateMarkdownFile->getPathname(), $newMarkdownFile->getPathname());
        $fileContents = file_get_contents($newMarkdownFile->getPathname());
        $fileContents1 = preg_replace('/##author##/', $author, $fileContents);
        $fileContents2 = preg_replace('/##title##/', $title, $fileContents1);
        $fileContents3 = preg_replace('/##url##/', $url, $fileContents2);
        $fileContents4 = preg_replace('/##tag##/', $tag->value, $fileContents3);
        $fileContents5 = preg_replace('/##description##/', $description, $fileContents4);
        file_put_contents($newMarkdownFile->getPathname(), $fileContents5);
        return new MarkdownFile(new SplFileInfo($newMarkdownFile->getPathname()));
    }
}
