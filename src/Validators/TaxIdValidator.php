<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Validators;

final class TaxIdValidator
{
    // Format: 7 digits, letter, /, letter, /, letter, /, 3 digits (e.g. 1234567A/B/C/000)
    private const string TAX_ID_REGEX = '/^\d{7}[A-Z]\/[A-Z]\/[A-Z]\/\d{3}$/';

    public static function validate(?string $taxId): bool
    {
        if ($taxId === null || $taxId === '') {
            return false;
        }

        return preg_match(self::TAX_ID_REGEX, $taxId) === 1;
    }
}