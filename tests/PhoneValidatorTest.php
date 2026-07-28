<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Tests;

use AmineZhioua\DegachePhp\Constants\Phone;
use AmineZhioua\DegachePhp\Formatters\PhoneFormatter;
use AmineZhioua\DegachePhp\Validators\PhoneValidator;
use PHPUnit\Framework\TestCase;

final class PhoneValidatorTest extends TestCase
{
    public function testValidatesCorrectNumbers(): void
    {
        self::assertTrue(PhoneValidator::validate('20123456'));
        self::assertTrue(PhoneValidator::validate('40123456'));
        self::assertTrue(PhoneValidator::validate('50123456'));
        self::assertTrue(PhoneValidator::validate('90123456'));
    }

    public function testFormatStripsCountryCodeCorrectly(): void
    {
        self::assertSame('+216 20 123 456', PhoneFormatter::format('+21620123456'));
        self::assertSame('+216 20 123 456', PhoneFormatter::format('20123456'));
    }

    public function testValidatesNumbersWithInternationalPrefix(): void
    {
        self::assertTrue(PhoneValidator::validate('+21620123456'));
        self::assertTrue(PhoneValidator::validate('+21650123456'));
        self::assertTrue(PhoneValidator::validate('+21690123456'));
    }

    public function testRejectsInvalidLength(): void
    {
        self::assertFalse(PhoneValidator::validate('2012345'));
        self::assertFalse(PhoneValidator::validate('201234567'));
        self::assertFalse(PhoneValidator::validate('+216201234567'));
    }

    public function testRejectsInvalidPrefixes(): void
    {
        self::assertFalse(PhoneValidator::validate('10123456'));
        self::assertFalse(PhoneValidator::validate('+21610123456'));
        self::assertFalse(PhoneValidator::validate('00123456'));
    }

    public function testRejectsNonNumericCharacters(): void
    {
        self::assertFalse(PhoneValidator::validate('2012345a'));
        self::assertFalse(PhoneValidator::validate('20-123456'));
        self::assertFalse(PhoneValidator::validate('+216 20123456'));
    }

    public function testRejectsEmptyAndNullInputs(): void
    {
        self::assertFalse(PhoneValidator::validate(''));
        self::assertFalse(PhoneValidator::validate(null));
    }

    public function testStrictModeAcceptsCleanNumbers(): void
    {
        self::assertTrue(PhoneValidator::validate('20123456', strict: true));
        self::assertTrue(PhoneValidator::validate('+21650123456', strict: true));
    }

    public function testStrictModeRejectsSpaces(): void
    {
        self::assertFalse(PhoneValidator::validate('20 123 456', strict: true));
        self::assertFalse(PhoneValidator::validate('+216 20123456', strict: true));
    }

    public function testStrictModeRejectsHyphens(): void
    {
        self::assertFalse(PhoneValidator::validate('20-123-456', strict: true));
        self::assertFalse(PhoneValidator::validate('+216-20123456', strict: true));
    }

    public function testStrictModeRejectsParentheses(): void
    {
        self::assertFalse(PhoneValidator::validate('(20)123456', strict: true));
        self::assertFalse(PhoneValidator::validate('+216(20)123456', strict: true));
    }

    public function testGetCarrierInfoForOoredoo(): void
    {
        $expected = Phone::CARRIERS['OOREDOO'];

        $carrier = PhoneValidator::getCarrierInfo('50123456');
        self::assertNotNull($carrier);
        self::assertSame($expected['name'], $carrier->name);
        self::assertSame($expected['prefixes'], $carrier->prefixes);

        $carrier = PhoneValidator::getCarrierInfo('+21650123456');
        self::assertNotNull($carrier);
        self::assertSame($expected['name'], $carrier->name);
    }

    public function testGetCarrierInfoForOrange(): void
    {
        $expected = Phone::CARRIERS['ORANGE'];

        $carrier = PhoneValidator::getCarrierInfo('40123456');
        self::assertNotNull($carrier);
        self::assertSame($expected['name'], $carrier->name);

        $carrier = PhoneValidator::getCarrierInfo('+21640123456');
        self::assertNotNull($carrier);
        self::assertSame($expected['name'], $carrier->name);
    }

    public function testGetCarrierInfoForTelecom(): void
    {
        $expected = Phone::CARRIERS['TELECOM'];

        $carrier = PhoneValidator::getCarrierInfo('90123456');
        self::assertNotNull($carrier);
        self::assertSame($expected['name'], $carrier->name);

        $carrier = PhoneValidator::getCarrierInfo('+21690123456');
        self::assertNotNull($carrier);
        self::assertSame($expected['name'], $carrier->name);
    }

    public function testGetCarrierInfoReturnsNullForInvalidNumbers(): void
    {
        self::assertNull(PhoneValidator::getCarrierInfo('1234567'));
        self::assertNull(PhoneValidator::getCarrierInfo('10123456'));
        self::assertNull(PhoneValidator::getCarrierInfo('2012345a'));
    }

    public function testGetCarrierInfoInStrictMode(): void
    {
        $expected = Phone::CARRIERS['OOREDOO'];

        $carrier = PhoneValidator::getCarrierInfo('50123456', strict: true);
        self::assertNotNull($carrier);
        self::assertSame($expected['name'], $carrier->name);

        self::assertNull(PhoneValidator::getCarrierInfo('50 123 456', strict: true));
        self::assertNull(PhoneValidator::getCarrierInfo('+216 50123456', strict: true));
        self::assertNull(PhoneValidator::getCarrierInfo('50-123-456', strict: true));
    }
}