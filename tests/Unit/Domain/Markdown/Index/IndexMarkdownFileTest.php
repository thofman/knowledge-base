<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Tests\Unit\Domain\Markdown\Index;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SplFileInfo;
use thofman\KnowledgeBase\Domain\FrontMatter\FrontMatter;
use thofman\KnowledgeBase\Domain\FrontMatter\FrontMatterCollection;
use thofman\KnowledgeBase\Domain\MarkdownFile\Index\IndexMarkdownFile;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFile;
use thofman\KnowledgeBase\Domain\Question\Tag;

#[Group('unit')]
final class IndexMarkdownFileTest extends TestCase
{
    #[Test]
    public function reindexAndReturn(): void
    {
        $frontMatterCollection = new FrontMatterCollection(
            new FrontMatter(
                new MarkdownFile(new SplFileInfo(__DIR__ . '/agile.md')),
                'Test author agile',
                'Test content agile',
                Tag::AGILE,
            ),
            new FrontMatter(
                new MarkdownFile(new SplFileInfo(__DIR__ . '/php.md')),
                'Test author php',
                'Test content php',
                Tag::PHP,
            ),
        );
        $indexMarkdownFile = new IndexMarkdownFile(new MarkdownFile(new SplFileInfo(__DIR__ . '/_index.md')));
        self::assertEquals(
            <<<MARKDOWN
            # Index of all articles

            ## Agile

            - [Test author agile - Test content agile](agile.md)

            ## PHP

            - [Test author php - Test content php](php.md)

            MARKDOWN,
            $indexMarkdownFile->reindexAndReturn(
                $frontMatterCollection->getSortedAscendingOnTagAuthorAndTitleCollection()
            )
        );
    }
}
