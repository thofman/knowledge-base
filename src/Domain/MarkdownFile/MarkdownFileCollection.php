<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\MarkdownFile;

use IteratorAggregate;

/**
 * @template-implements IteratorAggregate<non-negative-int, MarkdownFile>
 */
final class MarkdownFileCollection implements IteratorAggregate
{
    /** @var list<MarkdownFile> */
    private array $markdownFiles;

    public function __construct(
        MarkdownFile ...$markdownFiles,
    ) {
        $this->markdownFiles = $markdownFiles;
    }

    public function getIterator(): MarkdownFileCollectionIterator
    {
        return new MarkdownFileCollectionIterator($this);
    }

    /**
     * @return list<MarkdownFile>
     */
    public function asArray(): array
    {
        return $this->markdownFiles;
    }
}
