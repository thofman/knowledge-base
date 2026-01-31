<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\Helper;

interface EnumWithTitle
{
    public function getTitle(): string;
}
