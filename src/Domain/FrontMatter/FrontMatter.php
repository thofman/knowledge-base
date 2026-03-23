<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\FrontMatter;

use thofman\KnowledgeBase\Domain\MarkdownFile\MarkdownFile;
use thofman\KnowledgeBase\Domain\Question\Tag;

final readonly class FrontMatter
{
    public function __construct(
        public MarkdownFile $markdownFile,
        public string $author,
        public string $title,
        public Tag $tag,
    ) {
    }
}
