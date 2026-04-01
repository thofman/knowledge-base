<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\FrontMatter;

use IteratorAggregate;

/**
 * @template-implements IteratorAggregate<non-negative-int, FrontMatter>
 */
final readonly class FrontMatterCollection implements IteratorAggregate
{
    /** @var list<FrontMatter> */
    private array $frontMatters;

    public function __construct(
        FrontMatter ...$frontMatters,
    ) {
        $this->frontMatters = $frontMatters;
    }

    public function getIterator(): FrontMatterCollectionIterator
    {
        return new FrontMatterCollectionIterator($this);
    }

    /**
     * @return list<FrontMatter>
     */
    public function asArray(): array
    {
        return $this->frontMatters;
    }
}
