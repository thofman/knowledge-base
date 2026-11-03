<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Application\Article;

use SplFileInfo;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFilesDirectory;
use thofman\KnowledgeBase\Domain\MarkdownFile\Template\NewMarkdownFile;

final class NewMarkdownFileService
{
    public function getNewMarkdownFile(
        MarkdownFilesDirectory $markdownFilesDirectory,
        string $author,
        string $title,
    ): NewMarkdownFile {
        $authorAndTitle = sprintf('%s_%s', $author, $title);
        $fileName = preg_replace('/[^A-Za-z0-9-_]+/', '_', $authorAndTitle);
        $lowerCasedFilename = strtolower($fileName);
        $fileNameWithExtension = sprintf('%s.md', $lowerCasedFilename);
        $pathnameNewMarkdownFile = sprintf('%s/%s', $markdownFilesDirectory->getPathname(), $fileNameWithExtension);
        return new NewMarkdownFile(new SplFileInfo($pathnameNewMarkdownFile));
    }
}
