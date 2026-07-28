<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Formatters;

use AmineZhioua\DegachePhp\Constants\Phone;
use AmineZhioua\DegachePhp\Validators\PhoneValidator;

final class PhoneFormatter
{
    public static function format(?string $phoneNumber): ?string
    {
        if (!PhoneValidator::validate($phoneNumber)) {
            return null;
        }
    
        $cleaned = preg_replace('/\D/', '', $phoneNumber);
        $cleaned = preg_replace('/^216/', '', $cleaned);
    
        return sprintf(
            '%s %s %s %s',
            Phone::COUNTRY_CODE,
            substr($cleaned, 0, 2),
            substr($cleaned, 2, 3),
            substr($cleaned, 5),
        );
    }
}