<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\Tag;

use thofman\KnowledgeBase\Helper\EnumWithTitle;

enum Tag: string implements EnumWithTitle
{
    case AGILE = 'Agile';
    case PHP = 'PHP';
    case OOP = 'Object-oriented Programming';

    public function getTitle(): string
    {
        return match ($this) {
            self::AGILE => 'Agile',
            self::PHP => 'PHP',
            self::OOP => 'Object-oriented Programming',
        };
    }
}
