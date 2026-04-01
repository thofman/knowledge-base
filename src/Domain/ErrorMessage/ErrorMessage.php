<?php

declare(strict_types=1);

namespace thofman\KnowledgeBase\Domain\ErrorMessage;

final class ErrorMessage
{
    public static function shouldBe(string $subject, string $expectedValue, string $gotValue): string
    {
        return sprintf('%s should be "%s". Got: "%s"', ucfirst($subject), $expectedValue, $gotValue);
    }
}
