<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Tests;

use AmineZhioua\DegachePhp\Constants\Banks;
use AmineZhioua\DegachePhp\Validators\RibValidator;
use PHPUnit\Framework\TestCase;

final class RibValidatorTest extends TestCase
{
    public function testValidatesCorrectRib(): void
    {
        self::assertTrue(RibValidator::validate('01123456789012345678'));
        self::assertTrue(RibValidator::validate('08123456789012345678'));
    }

    public function testRejectsInvalidFormat(): void
    {
        self::assertFalse(RibValidator::validate('0123456789012345')); // too short
        self::assertFalse(RibValidator::validate('012345678901234567890')); // too long
        self::assertFalse(RibValidator::validate('0123456789a123456789')); // non-digit
    }

    public function testRejectsNonExistentBankCode(): void
    {
        self::assertFalse(RibValidator::validate('99123456789012345678'));
    }

    public function testRejectsInvalidBranchCodeFormat(): void
    {
        self::assertFalse(RibValidator::validate('0112345678901234567'));
    }

    public function testRejectsInvalidAccountNumberFormat(): void
    {
        self::assertFalse(RibValidator::validate('01123abc456789012345'));
    }

    public function testRejectsInvalidKeyFormat(): void
    {
        self::assertFalse(RibValidator::validate('0112345678901234567a'));
    }

    public function testGetBankFromRibReturnsCorrectBank(): void
    {
        $atb = Banks::BANKS['ATB'];
        $bank = RibValidator::getBankFromRib('01123456789012345678');
        self::assertNotNull($bank);
        self::assertSame($atb['code'], $bank->code);
        self::assertSame($atb['name'], $bank->name);

        $biat = Banks::BANKS['BIAT'];
        $bank = RibValidator::getBankFromRib('08123456789012345678');
        self::assertNotNull($bank);
        self::assertSame($biat['code'], $bank->code);
        self::assertSame($biat['name'], $bank->name);
    }

    public function testGetBankFromRibReturnsNullForInvalidFormat(): void
    {
        self::assertNull(RibValidator::getBankFromRib('0123456789'));
        self::assertNull(RibValidator::getBankFromRib('0123456789abcdefghij'));
    }

    public function testGetBankFromRibReturnsNullForNonExistentBankCode(): void
    {
        self::assertNull(RibValidator::getBankFromRib('99123456789012345678'));
    }
}