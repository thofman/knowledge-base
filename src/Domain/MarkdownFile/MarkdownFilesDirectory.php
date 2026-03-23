<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\MarkdownFile;

use SplFileInfo;

final class MarkdownFilesDirectory
{
    public function __construct(
        public SplFileInfo $splFileInfo,
    ) {
        assert($this->splFileInfo->isDir());
        assert($this->splFileInfo->isReadable());
    }

    public function getPathname(): string
    {
        return $this->splFileInfo->getPathname();
    }
}
