<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\MarkdownFile;

use SplFileInfo;

final readonly class MarkdownFile
{
    public function __construct(
        public SplFileInfo $splFileInfo,
    ) {
        assert($this->splFileInfo->isFile());
        assert($this->splFileInfo->isReadable());
        assert($this->splFileInfo->getExtension() === 'md');
    }

    public function getPathname(): string
    {
        return $this->splFileInfo->getPathname();
    }

    public function getFilename(): string
    {
        return $this->splFileInfo->getFilename();
    }
}
