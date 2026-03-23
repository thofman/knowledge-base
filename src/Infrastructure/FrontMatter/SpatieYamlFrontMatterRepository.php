<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\Infrastructure\FrontMatter;

use Spatie\YamlFrontMatter\YamlFrontMatter;
use thofman\KnowledgeBase\Domain\FrontMatter\FrontMatter;
use thofman\KnowledgeBase\Domain\FrontMatter\FrontMatterRepository;
use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFile;
use thofman\KnowledgeBase\Domain\Question\Tag;

final class SpatieYamlFrontMatterRepository implements FrontMatterRepository
{
    public function getFrontMatter(MarkdownFile $markdownFile): FrontMatter
    {
        $document = YamlFrontMatter::parseFile($markdownFile->getPathname());
        $tags = $document->matter('tags');
        return new FrontMatter(
            $markdownFile,
            $document->matter('author'),
            $document->matter('title'),
            Tag::tryFrom($tags[array_key_first($tags)]),
        );
    }

    public function getFrontMatters(array $markdownFiles): array
    {
        return array_map(
            $this->getFrontMatter(...),
            $markdownFiles,
        );
    }
}
