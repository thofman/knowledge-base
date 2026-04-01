<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\MarkdownFile;

use DomainException;
use SplFileInfo;
use thofman\KnowledgeBase\Domain\ErrorMessage\ErrorMessage;

final readonly class MarkdownFile
{
    private const string EXTENSION = 'md';

    public function __construct(
        public SplFileInfo $splFileInfo,
    ) {
        if (!$this->splFileInfo->isFile()) {
            throw new DomainException(ErrorMessage::isNot($this->splFileInfo->getPathname(), 'a file'));
        }
        if (!$this->splFileInfo->isReadable()) {
            throw new DomainException(ErrorMessage::isNot($this->splFileInfo->getPathname(), 'readable'));
        }
        if ($this->splFileInfo->getExtension() !== self::EXTENSION) {
            throw new DomainException(
                ErrorMessage::shouldBe('Extension', self::EXTENSION, $this->splFileInfo->getExtension())
            );
        }
    }

    public function getPathname(): string
    {
        return $this->splFileInfo->getPathname();
    }

    public function getFilename(): string
    {
        return $this->splFileInfo->getFilename();
    }

    public function isWritable(): bool
    {
        return $this->splFileInfo->isWritable();
    }
}
