<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp;

use AmineZhioua\DegachePhp\DTO\CarrierInfo;
use AmineZhioua\DegachePhp\Formatters\PhoneFormatter;
use AmineZhioua\DegachePhp\Validators\PhoneValidator;
use AmineZhioua\DegachePhp\Validators\CinValidator;

/**
 * Facade providing convenient access to DegachePhp's Tunisian utilities.
 *
 * For advanced usage (e.g. dependency injection, testing with mocks),
 * prefer using the individual Validator/Formatter classes directly.
 */
final class Degache
{
    /*
        Phone Number all Methods
    */
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


    /*
        CIN all methods
    */
    public static function validateCIN(?string $cin): bool
    {
        return CinValidator::validate($cin);
    }
}