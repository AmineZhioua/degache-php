<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Tests;

use AmineZhioua\DegachePhp\Validators\PostalCodeValidator;
use PHPUnit\Framework\TestCase;

final class PostalCodeValidatorTest extends TestCase
{
    public function testValidatesRealExistingPostalCodes(): void
    {
        self::assertTrue(PostalCodeValidator::validate('2001')); // Ariana
        self::assertTrue(PostalCodeValidator::validate('1000')); // Tunis
    }

    public function testRejectsWellFormedButNonExistentCodes(): void
    {
        self::assertFalse(PostalCodeValidator::validate('9999'));
        self::assertFalse(PostalCodeValidator::validate('0000'));
        self::assertFalse(PostalCodeValidator::validate('1010'));
    }

    public function testRejectsInvalidLength(): void
    {
        self::assertFalse(PostalCodeValidator::validate('200'));   // too short
        self::assertFalse(PostalCodeValidator::validate('20011')); // too long
    }

    public function testRejectsNonNumericCharacters(): void
    {
        self::assertFalse(PostalCodeValidator::validate('200A'));
        self::assertFalse(PostalCodeValidator::validate('ARIA'));
    }

    public function testRejectsEmptyAndNullInputs(): void
    {
        self::assertFalse(PostalCodeValidator::validate(''));
        self::assertFalse(PostalCodeValidator::validate(null));
    }
}