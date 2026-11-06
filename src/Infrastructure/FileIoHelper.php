<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Infrastructure;

use thofman\KnowledgeBase\Application\IoHelper;

final class FileIoHelper implements IoHelper
{
    public function write(string $path, string $content): void
    {
        file_put_contents($path, $content);
    }
}
