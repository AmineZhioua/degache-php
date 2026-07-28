<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Validators;

use AmineZhioua\DegachePhp\Constants\Phone;
use AmineZhioua\DegachePhp\DTO\CarrierInfo;

final class PhoneValidator
{
    private const string PHONE_REGEX = '/^[2-9]\d{7}$/';
    private const string STRICT_PHONE_REGEX = '/^(?:\+216)?[2-9]\d{7}$/';

    /**
     * Validates a Tunisian mobile phone number.
     *
     * @param bool $strict When true, rejects spaces, hyphens, parentheses, etc.
     */
    public static function validate(?string $phoneNumber, bool $strict = false): bool
    {
        if ($phoneNumber === null || $phoneNumber === '') {
            return false;
        }

        if ($strict && preg_match(self::STRICT_PHONE_REGEX, $phoneNumber) !== 1) {
            return false;
        }

        $normalized = preg_replace('/^\+216/', '', $phoneNumber);

        if (preg_match(self::PHONE_REGEX, $normalized) !== 1) {
            return false;
        }

        return in_array($normalized[0], Phone::validPrefixes(), true);
    }

    public static function getCarrierInfo(?string $phoneNumber, bool $strict = false): ?CarrierInfo
    {
        if (!self::validate($phoneNumber, $strict)) {
            return null;
        }

        $normalized = preg_replace('/^\+216/', '', $phoneNumber);
        $prefix = $normalized[0];

        foreach (Phone::CARRIERS as $carrier) {
            if (in_array($prefix, $carrier['prefixes'], true)) {
                return new CarrierInfo($carrier['name'], $carrier['prefixes']);
            }
        }

        return null;
    }
}