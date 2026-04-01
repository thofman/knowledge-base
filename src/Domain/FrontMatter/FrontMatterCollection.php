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

    public function getSortedAscendingOnTagAuthorAndTitleCollection(): self
    {
        $frontMatters = $this->frontMatters;
        uasort(
            $frontMatters,
            static function (FrontMatter $first, FrontMatter $second): int {
                return strcasecmp($first->tag->value, $second->tag->value)
                    ?: strcasecmp($first->author, $second->author)
                    ?: strcasecmp($first->title, $second->title)
                ;
            }
        );
        return new self(
            ...$frontMatters,
        );
    }
}
