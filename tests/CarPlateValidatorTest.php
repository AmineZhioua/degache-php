<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Tests;

use AmineZhioua\DegachePhp\Enums\CarPlateType;
use AmineZhioua\DegachePhp\Validators\CarPlateValidator;
use PHPUnit\Framework\TestCase;


#[CoversClass(CarPlateValidator::class)]
final class CarPlateValidatorTest extends TestCase
{
    public function testValidatesCorrectStandardPlates(): void
    {
        self::assertTrue(CarPlateValidator::validate('123 تونس 4567'));
        self::assertTrue(CarPlateValidator::validate('12 تونس 3456'));
    }

    public function testValidatesCorrectSpecialPlates(): void
    {
        self::assertTrue(CarPlateValidator::validate('RS 123 تونس'));
        self::assertTrue(CarPlateValidator::validate('RS 12 تونس'));
    }

    public function testNormalizesExtraSpaces(): void
    {
        self::assertTrue(CarPlateValidator::validate('123  تونس  4567'));
        self::assertTrue(CarPlateValidator::validate(' 12 تونس 3456 '));
        self::assertTrue(CarPlateValidator::validate('RS  123  تونس'));
    }

    public function testNormalizesLowercaseRs(): void
    {
        self::assertTrue(CarPlateValidator::validate('rs 123 تونس'));
    }

    public function testRejectsInvalidFormats(): void
    {
        self::assertFalse(CarPlateValidator::validate('1234 تونس 4567')); // too many digits in prefix
        self::assertFalse(CarPlateValidator::validate('123 تونس 456'));   // too few digits in suffix
        self::assertFalse(CarPlateValidator::validate('123 ALG 4567'));   // invalid region code
        self::assertFalse(CarPlateValidator::validate('RS تونس 123'));    // invalid special format
        self::assertFalse(CarPlateValidator::validate('RS 1234 تونس'));   // too many digits in special number
        self::assertFalse(CarPlateValidator::validate('123 TUN 4567'));   // Latin instead of Arabic
    }

    public function testRejectsEmptyAndNullInputs(): void
    {
        self::assertFalse(CarPlateValidator::validate(''));
        self::assertFalse(CarPlateValidator::validate(null));
    }

    public function testValidatesOnlyStandardWhenTypeIsStandard(): void
    {
        self::assertTrue(CarPlateValidator::validate('123 تونس 4567', CarPlateType::Standard));
        self::assertFalse(CarPlateValidator::validate('RS 123 تونس', CarPlateType::Standard));
    }

    public function testValidatesOnlySpecialWhenTypeIsSpecial(): void
    {
        self::assertTrue(CarPlateValidator::validate('RS 123 تونس', CarPlateType::Special));
        self::assertFalse(CarPlateValidator::validate('123 تونس 4567', CarPlateType::Special));
    }

    public function testValidatesAnyValidPlateWhenTypeIsAny(): void
    {
        self::assertTrue(CarPlateValidator::validate('123 تونس 4567', CarPlateType::Any));
        self::assertTrue(CarPlateValidator::validate('RS 123 تونس', CarPlateType::Any));
    }

    public function testValidatesCorrectPlatesInStrictMode(): void
    {
        self::assertTrue(CarPlateValidator::validate('123 تونس 4567', strict: true));
        self::assertTrue(CarPlateValidator::validate('RS 123 تونس', strict: true));
    }

    public function testRejectsExtraSpacesInStrictMode(): void
    {
        self::assertFalse(CarPlateValidator::validate('123  تونس  4567', strict: true));
        self::assertFalse(CarPlateValidator::validate(' 12 تونس 3456 ', strict: true));
    }

    public function testRejectsLatinInsteadOfArabicInStrictMode(): void
    {
        self::assertFalse(CarPlateValidator::validate('123 TUN 4567', strict: true));
        self::assertFalse(CarPlateValidator::validate('RS 123 TUN', strict: true));
    }

    public function testRejectsLowercaseRsInStrictMode(): void
    {
        self::assertFalse(CarPlateValidator::validate('rs 123 تونس', strict: true));
    }

    public function testGetInfoForStandardPlate(): void
    {
        $info = CarPlateValidator::getInfo('123 تونس 4567');

        self::assertNotNull($info);
        self::assertSame(CarPlateType::Standard, $info->type);
        self::assertSame(
            ['prefix' => '123', 'region' => 'تونس', 'suffix' => '4567'],
            $info->components,
        );
    }

    public function testGetInfoForSpecialPlate(): void
    {
        $info = CarPlateValidator::getInfo('RS 123 تونس');

        self::assertNotNull($info);
        self::assertSame(CarPlateType::Special, $info->type);
        self::assertSame(
            ['prefix' => 'RS', 'number' => '123', 'region' => 'تونس'],
            $info->components,
        );
    }

    public function testGetInfoNormalizesExtraSpaces(): void
    {
        $info = CarPlateValidator::getInfo('123  تونس  4567');

        self::assertNotNull($info);
        self::assertSame(CarPlateType::Standard, $info->type);
        self::assertSame(
            ['prefix' => '123', 'region' => 'تونس', 'suffix' => '4567'],
            $info->components,
        );
    }

    public function testGetInfoNormalizesLowercaseRs(): void
    {
        $info = CarPlateValidator::getInfo('rs 123 تونس');

        self::assertNotNull($info);
        self::assertSame(CarPlateType::Special, $info->type);
        self::assertSame(
            ['prefix' => 'RS', 'number' => '123', 'region' => 'تونس'],
            $info->components,
        );
    }

    public function testGetInfoReturnsNullForInvalidPlates(): void
    {
        self::assertNull(CarPlateValidator::getInfo('1234 تونس 4567')); // too many digits in prefix
        self::assertNull(CarPlateValidator::getInfo('123 ALG 4567'));   // invalid region code
        self::assertNull(CarPlateValidator::getInfo('123 TUN 4567'));   // Latin instead of Arabic
        self::assertNull(CarPlateValidator::getInfo(''));
    }

    public function testGetInfoInStrictMode(): void
    {
        $info = CarPlateValidator::getInfo('123 تونس 4567', strict: true);

        self::assertNotNull($info);
        self::assertSame(CarPlateType::Standard, $info->type);
        self::assertSame(
            ['prefix' => '123', 'region' => 'تونس', 'suffix' => '4567'],
            $info->components,
        );
    }

    public function testGetInfoReturnsNullForExtraSpacesInStrictMode(): void
    {
        self::assertNull(CarPlateValidator::getInfo('123  تونس  4567', strict: true));
    }

    public function testGetInfoReturnsNullForLatinInsteadOfArabicInStrictMode(): void
    {
        self::assertNull(CarPlateValidator::getInfo('123 TUN 4567', strict: true));
    }

    public function testGetInfoReturnsNullForLowercaseRsInStrictMode(): void
    {
        self::assertNull(CarPlateValidator::getInfo('rs 123 تونس', strict: true));
    }
}