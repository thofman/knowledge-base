<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Tests\Integration\Application\Article;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SplFileInfo;
use thofman\KnowledgeBase\Application\Article\ReplaceTemplateService;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFile;
use thofman\KnowledgeBase\Domain\MarkdownFile\Template\NewMarkdownFile;
use thofman\KnowledgeBase\Domain\MarkdownFile\Template\TemplateMarkdownFile;
use thofman\KnowledgeBase\Domain\Question\Tag;
use thofman\KnowledgeBase\Infrastructure\FileIoHelper;

#[Group('integration')]
final class ReplaceTemplateServiceTest extends TestCase
{
    private string $directory;

    protected function setUp(): void
    {
        $this->directory = sys_get_temp_dir() . '/replace-template-' . uniqid('', true);
        mkdir($this->directory);
    }

    protected function tearDown(): void
    {
        array_map(unlink(...), glob($this->directory . '/*') ?: []);
        rmdir($this->directory);
    }

    #[Test]
    public function itReplacesAllPlaceholdersInTheNewFile(): void
    {
        $templatePath = $this->directory . '/template.md';
        $template = "---\nauthor: ##author##\ntitle: ##title##\nurl: ##url##\n'
            . 'tag: ##tag##\n---\n##description##\n";
        file_put_contents($templatePath, $template);
        $newPath = $this->directory . '/new.md';

        $result = new ReplaceTemplateService(
            new FileIoHelper(),
        )
            ->replaceTemplate(
                new TemplateMarkdownFile(new MarkdownFile(new SplFileInfo($templatePath))),
                new NewMarkdownFile(new SplFileInfo($newPath)),
                'Tom Scott',
                'The Problem with Time',
                'https://example.com/video',
                Tag::PHP,
                'A description',
            )
        ;

        self::assertSame($newPath, $result->getPathname());
        self::assertSame(
            "---\nauthor: Tom Scott\ntitle: The Problem with Time\nurl: https://example.com/video\n'
            . 'tag: PHP\n---\nA description\n",
            file_get_contents($newPath),
        );
    }

    #[Test]
    public function itReplacesEveryOccurrenceOfAPlaceholder(): void
    {
        $templatePath = $this->directory . '/template.md';
        file_put_contents($templatePath, '##title## and ##title##');
        $newPath = $this->directory . '/new.md';

        new ReplaceTemplateService(
            new FileIoHelper(),
        )
            ->replaceTemplate(
                new TemplateMarkdownFile(new MarkdownFile(new SplFileInfo($templatePath))),
                new NewMarkdownFile(new SplFileInfo($newPath)),
                'a',
                'Title',
                'u',
                Tag::GIT,
                'd',
            )
        ;

        self::assertSame('Title and Title', file_get_contents($newPath));
    }

    #[Test]
    public function itLeavesTheTemplateUntouched(): void
    {
        $templatePath = $this->directory . '/template.md';
        file_put_contents($templatePath, '##author##');

        new ReplaceTemplateService(
            new FileIoHelper(),
        )
            ->replaceTemplate(
                new TemplateMarkdownFile(new MarkdownFile(new SplFileInfo($templatePath))),
                new NewMarkdownFile(new SplFileInfo($this->directory . '/new.md')),
                'Someone',
                't',
                'u',
                Tag::AGILE,
                'd',
            )
        ;

        self::assertSame('##author##', file_get_contents($templatePath));
    }
}
