<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\Question\Sanitization;

final readonly class StringSanitizer
{
    public function sanitize(string $value): string
    {
        return htmlspecialchars(strip_tags(trim($value)), ENT_NOQUOTES, 'UTF-8');
    }
}
