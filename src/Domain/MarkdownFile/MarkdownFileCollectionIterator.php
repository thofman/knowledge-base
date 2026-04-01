<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\MarkdownFile;

use Iterator;

/**
 * @template-implements Iterator<non-negative-int, MarkdownFile>
 */
final class MarkdownFileCollectionIterator implements Iterator
{
    /** @var list<MarkdownFile> */
    private readonly array $markdownFiles;

    private int $position = 0;

    public function __construct(
        MarkdownFileCollection $markdownFileCollection,
    ) {
        $this->markdownFiles = $markdownFileCollection->asArray();
    }

    public function current(): MarkdownFile
    {
        assert($this->valid());
        return $this->markdownFiles[$this->position];
    }

    public function next(): void
    {
        $this->position++;
    }

    /**
     * @return non-negative-int
     */
    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->markdownFiles[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}
