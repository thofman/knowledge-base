<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Infrastructure;

use thofman\KnowledgeBase\Application\IoHelper;

final readonly class FileIoHelper implements IoHelper
{
    public function read(string $path): string
    {
        return file_get_contents($path);
    }

    public function write(string $path, string $content): void
    {
        file_put_contents($path, $content);
    }

    public function copy(string $originalPath, string $destinationPath): void
    {
        copy($originalPath, $destinationPath);
    }
}
