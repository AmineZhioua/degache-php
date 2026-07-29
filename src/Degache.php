<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp;

use AmineZhioua\DegachePhp\DTO\CarrierInfo;
use AmineZhioua\DegachePhp\Formatters\PhoneFormatter;
use AmineZhioua\DegachePhp\Validators\PhoneValidator;

/**
 * Facade providing convenient access to DegachePhp's Tunisian utilities.
 *
 * For advanced usage (e.g. dependency injection, testing with mocks),
 * prefer using the individual Validator/Formatter classes directly.
 */
final class Degache
{
    public static function validatePhoneNumber(?string $phoneNumber, bool $strict = false): bool
    {
        return PhoneValidator::validate($phoneNumber, $strict);
    }

    public static function getPhoneCarrierInfo(?string $phoneNumber, bool $strict = false): ?CarrierInfo
    {
        return PhoneValidator::getCarrierInfo($phoneNumber, $strict);
    }

    public static function formatPhoneNumber(?string $phoneNumber): ?string
    {
        return PhoneFormatter::format($phoneNumber);
    }
}