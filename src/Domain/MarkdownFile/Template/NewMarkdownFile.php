<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\MarkdownFile\Template;

use DomainException;
use SplFileInfo;
use thofman\KnowledgeBase\Domain\ErrorMessage\ErrorMessage;

final class NewMarkdownFile
{
    private const string EXTENSION = 'md';

    public function __construct(
        public SplFileInfo $splFileInfo,
    ) {
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
}
