<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\MarkdownFile\Index;

use DomainException;
use thofman\KnowledgeBase\Domain\ErrorMessage\ErrorMessage;
use thofman\KnowledgeBase\Domain\FrontMatter\FrontMatterCollection;
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

    public function reindexAndReturn(FrontMatterCollection $frontMatterCollection): string
    {
        $return = '# Index of all articles';
        $return .= PHP_EOL;
        $tagIndex = [];
        foreach ($frontMatterCollection as $frontMatter) {
            if (!in_array($frontMatter->tag->value, $tagIndex, true)) {
                $tagIndex[] = $frontMatter->tag->value;
                $return .= PHP_EOL;
                $return .= sprintf('## %s', $frontMatter->tag->value);
                $return .= PHP_EOL;
                $return .= PHP_EOL;
            }
            $return .= sprintf(
                '- [%s - %s](%s)',
                $frontMatter->author,
                $frontMatter->title,
                $frontMatter->markdownFile->getFilename()
            );
            $return .= PHP_EOL;
        }
        return $return;
    }
}
