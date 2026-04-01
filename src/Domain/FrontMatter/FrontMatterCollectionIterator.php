<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\FrontMatter;

use Iterator;

/**
 * @template-implements Iterator<non-negative-int, FrontMatter>
 */
final class FrontMatterCollectionIterator implements Iterator
{
    /** @var list<FrontMatter> */
    private readonly array $frontMatters;

    private int $position = 0;

    public function __construct(
        FrontMatterCollection $frontMatterCollection,
    ) {
        $this->frontMatters = $frontMatterCollection->asArray();
    }

    public function current(): FrontMatter
    {
        assert($this->valid());
        return $this->frontMatters[$this->position];
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
        return isset($this->frontMatters[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}
