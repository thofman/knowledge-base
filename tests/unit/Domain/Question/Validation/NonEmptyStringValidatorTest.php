<?php
declare(strict_types=1);

namespace thofman\KnowledgeBase\tests\unit\Domain\Question\Validation;

use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use thofman\KnowledgeBase\Domain\Question\Validation\NonEmptyStringValidator;
use thofman\KnowledgeBase\Domain\Question\Validation\ValidationResult;

final class NonEmptyStringValidatorTest extends TestCase
{
    #[Test]
    #[DataProvider('provideDataToTestTheNonEmptyStringValidator')]
    public function theNonEmptyStringValidator(string $subject, string $value, ValidationResult $expectedResult): void
    {
        $validator = new NonEmptyStringValidator($subject);
        self::assertEquals($expectedResult, $validator->validate($value));
    }

    public static function provideDataToTestTheNonEmptyStringValidator(): Generator
    {
        yield ['Title', 'test', ValidationResult::valid('test')];
        yield ['Title', ' test ', ValidationResult::valid('test')];
        yield ['Title', '', ValidationResult::invalid('Title cannot be empty')];
        yield ['Title', ' ', ValidationResult::invalid('Title cannot be empty')];
    }
}
