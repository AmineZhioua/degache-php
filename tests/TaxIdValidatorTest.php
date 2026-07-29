<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Tests;

use AmineZhioua\DegachePhp\Validators\TaxIdValidator;
use PHPUnit\Framework\TestCase;

#[CoversClass(TaxIdValidator::class)]
final class TaxIdValidatorTest extends TestCase
{
    public function testValidatesCorrectTaxIds(): void
    {
        self::assertTrue(TaxIdValidator::validate('1234567A/B/C/000'));
        self::assertTrue(TaxIdValidator::validate('7654321M/P/N/123'));
    }

    public function testRejectsInvalidDigitCounts(): void
    {
        self::assertFalse(TaxIdValidator::validate('123456A/B/C/000'));   // too few prefix digits
        self::assertFalse(TaxIdValidator::validate('12345678A/B/C/000')); // too many prefix digits
        self::assertFalse(TaxIdValidator::validate('1234567A/B/C/00'));   // too few suffix digits
        self::assertFalse(TaxIdValidator::validate('1234567A/B/C/0000')); // too many suffix digits
    }

    public function testRejectsLowercaseLetters(): void
    {
        self::assertFalse(TaxIdValidator::validate('1234567a/B/C/000'));
    }

    public function testRejectsMissingSlashes(): void
    {
        self::assertFalse(TaxIdValidator::validate('1234567A B/C/000'));
    }

    public function testRejectsEmptyAndNullInputs(): void
    {
        self::assertFalse(TaxIdValidator::validate(''));
        self::assertFalse(TaxIdValidator::validate(null));
    }
}