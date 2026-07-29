<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Tests;

use AmineZhioua\DegachePhp\Validators\CinValidator;
use PHPUnit\Framework\TestCase;

#[CoversClass(CinValidator::class)]
final class CinValidatorTest extends TestCase
{
    public function testValidatesCorrectCinNumbers(): void
    {
        self::assertTrue(CinValidator::validate('12345678'));
        self::assertTrue(CinValidator::validate('00123456'));
    }

    public function testRejectsInvalidLength(): void
    {
        self::assertFalse(CinValidator::validate('1234567'));   // too short
        self::assertFalse(CinValidator::validate('123456789')); // too long
    }

    public function testRejectsNonNumericCharacters(): void
    {
        self::assertFalse(CinValidator::validate('1234567A'));
        self::assertFalse(CinValidator::validate('ABCDEFGH'));
        self::assertFalse(CinValidator::validate('1234-678'));
        self::assertFalse(CinValidator::validate('1234|#•@'));
        self::assertFalse(CinValidator::validate('99999999')); // starts with 9, not 0/1
    }

    public function testRejectsEmptyAndNullInputs(): void
    {
        self::assertFalse(CinValidator::validate(''));
        self::assertFalse(CinValidator::validate(null));
    }
}