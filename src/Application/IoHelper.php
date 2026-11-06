<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Application;

interface IoHelper
{
    public function read(string $path): string;

    public function write(string $path, string $content): void;

    public function copy(string $originalPath, string $destinationPath): void;
}
