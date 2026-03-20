<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\Question;

enum Tag: string
{
    case AGILE = 'Agile';
    case GIT = 'Git';
    case OOP = 'Object-oriented Programming';
    case PHP = 'PHP';
    case SOFTWARE_ARCHITECTURE = 'Software Architecture';
}
