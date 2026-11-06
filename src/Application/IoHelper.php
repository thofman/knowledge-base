<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Application;

interface IoHelper
{
    public function write(string $path, string $content): void;
}
