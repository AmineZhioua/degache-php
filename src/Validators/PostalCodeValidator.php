<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Validators;

use AmineZhioua\DegachePhp\Constants\Regions;

final class PostalCodeValidator
{
    private const string POSTAL_CODE_REGEX = '/^\d{4}$/';

    public static function validate(?string $postalCode): bool
    {
        if ($postalCode === null || $postalCode === '') {
            return false;
        }

        if (preg_match(self::POSTAL_CODE_REGEX, $postalCode) !== 1) {
            return false;
        }

        return array_key_exists($postalCode, Regions::postalCodesMap());
    }
}