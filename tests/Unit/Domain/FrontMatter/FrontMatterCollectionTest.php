<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Tests\Unit\Domain\FrontMatter;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SplFileInfo;
use thofman\KnowledgeBase\Domain\FrontMatter\FrontMatter;
use thofman\KnowledgeBase\Domain\FrontMatter\FrontMatterCollection;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFile;
use thofman\KnowledgeBase\Domain\Question\Tag;

#[Group('unit')]
final class FrontMatterCollectionTest extends TestCase
{
    #[Test]
    public function getSortedAscendingOnTagAuthorAndTitleCollection(): void
    {
        $frontMatterSoftwareAuthorB = new FrontMatter(
            new MarkdownFile(new SplFileInfo('test')),
            'Test author B',
            'Test content',
            Tag::SOFTWARE_ARCHITECTURE,
        );
        $frontMatterSoftwareAuthorAContentB = new FrontMatter(
            new MarkdownFile(new SplFileInfo('test')),
            'Test author A',
            'Test content B',
            Tag::SOFTWARE_ARCHITECTURE,
        );
        $frontMatterSoftwareAuthorAContentA = new FrontMatter(
            new MarkdownFile(new SplFileInfo('test')),
            'Test author A',
            'Test content A',
            Tag::SOFTWARE_ARCHITECTURE,
        );
        $frontMatterSoftwareAuthorA = new FrontMatter(
            new MarkdownFile(new SplFileInfo('test')),
            'Test author A',
            'Test content',
            Tag::SOFTWARE_ARCHITECTURE,
        );
        $frontMatterAgile = new FrontMatter(
            new MarkdownFile(new SplFileInfo('test')),
            'Test author',
            'Test content',
            Tag::AGILE,
        );
        $frontMatterPhp = new FrontMatter(
            new MarkdownFile(new SplFileInfo('test')),
            'Test author',
            'Test content',
            Tag::PHP,
        );
        $collection = new FrontMatterCollection(
            $frontMatterSoftwareAuthorB,
            $frontMatterSoftwareAuthorAContentB,
            $frontMatterSoftwareAuthorAContentA,
            $frontMatterSoftwareAuthorA,
            $frontMatterAgile,
            $frontMatterPhp,
        );
        self::assertEquals(
            [
                $frontMatterAgile,
                $frontMatterPhp,
                $frontMatterSoftwareAuthorA,
                $frontMatterSoftwareAuthorAContentA,
                $frontMatterSoftwareAuthorAContentB,
                $frontMatterSoftwareAuthorB,
            ],
            $collection->getSortedAscendingOnTagAuthorAndTitleCollection()->asArray(),
        );
    }
}
