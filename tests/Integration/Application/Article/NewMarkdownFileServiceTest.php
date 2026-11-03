<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Tests\Integration\Application\Article;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SplFileInfo;
use thofman\KnowledgeBase\Application\Article\NewMarkdownFileService;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFilesDirectory;

#[Group('integration')]
final class NewMarkdownFileServiceTest extends TestCase
{
    #[Test]
    #[DataProvider('provideFileNames')]
    public function itBuildsTheFileNameFromAuthorAndTitle(string $author, string $title, string $expectedFileName): void
    {
        $directory = new MarkdownFilesDirectory(new SplFileInfo(sys_get_temp_dir()));
        $result = new NewMarkdownFileService()->getNewMarkdownFile($directory, $author, $title);
        self::assertSame(sys_get_temp_dir() . '/' . $expectedFileName, $result->getPathname());
    }

    /**
     * @return iterable<string, array{author: string, title: string, expectedFileName: string}>
     */
    public static function provideFileNames(): iterable
    {
        yield 'simple' => [
            'author' => 'author',
            'title' => 'title',
            'expectedFileName' => 'author_title.md',
        ];
        yield 'lowercases' => [
            'author' => 'Tom Scott',
            'title' => 'The Problem',
            'expectedFileName' => 'tom_scott_the_problem.md',
        ];
        yield 'special characters' => [
            'author' => 'A.B',
            'title' => 'What?! Is: this',
            'expectedFileName' => 'a_b_what_is_this.md',
        ];
        yield 'keeps dashes and digits' => [
            'author' => 'a-b',
            'title' => 'PHP 8-4',
            'expectedFileName' => 'a-b_php_8-4.md',
        ];
    }
}
