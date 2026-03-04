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
    public function theNonEmptyStringValidator(string $value, ValidationResult $expectedResult): void
    {
        $validator = new NonEmptyStringValidator();
        self::assertEquals($expectedResult, $validator->validate($value));
    }

    public static function provideDataToTestTheNonEmptyStringValidator(): Generator
    {
        yield ['test', ValidationResult::valid('test')];
        yield [' test ', ValidationResult::valid('test')];
        yield ['', ValidationResult::invalid('The value cannot be empty')];
        yield [' ', ValidationResult::invalid('The value cannot be empty')];
    }
}
