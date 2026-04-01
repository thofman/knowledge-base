<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\MarkdownFile;

use DomainException;
use SplFileInfo;
use thofman\KnowledgeBase\Domain\ErrorMessage\ErrorMessage;

final class MarkdownFilesDirectory
{
    public function __construct(
        public SplFileInfo $splFileInfo,
    ) {
        if (!$this->splFileInfo->isDir()) {
            throw new DomainException(ErrorMessage::isNot($this->splFileInfo->getPathname(), 'a directory'));
        }
        if (!$this->splFileInfo->isReadable()) {
            throw new DomainException(ErrorMessage::isNot($this->splFileInfo->getPathname(), 'readable'));
        }
    }

    public function getPathname(): string
    {
        return $this->splFileInfo->getPathname();
    }
}
