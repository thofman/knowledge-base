<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\MarkdownFile\Index;

use DomainException;
use thofman\KnowledgeBase\Domain\ErrorMessage\ErrorMessage;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFile;

final readonly class IndexMarkdownFile
{
    private const string FILE_NAME = '_index.md';

    public function __construct(
        private MarkdownFile $markdownFile,
    ) {
        if ($markdownFile->getFilename() !== self::FILE_NAME) {
            throw new DomainException(
                ErrorMessage::shouldBe('Filename', self::FILE_NAME, $markdownFile->getFilename())
            );
        }
    }

    public function getFilename(): string
    {
        return $this->markdownFile->getFilename();
    }
}
