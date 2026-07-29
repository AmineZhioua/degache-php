<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Validators;

final class CinValidator
{
    /**
     * 0 or 1 followed by 7 digits, matching the Tunisian CIN format.
     */
    private const string CIN_REGEX = '/^[01]\d{7}$/';

    public static function validate(?string $cin): bool
    {
        if ($cin === null || $cin === '') {
            return false;
        }

        return preg_match(self::CIN_REGEX, $cin) === 1;
    }
}