<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Validators;

use AmineZhioua\DegachePhp\DTO\CarPlateInfo;
use AmineZhioua\DegachePhp\Enums\CarPlateType;

final class CarPlateValidator
{
    // Format: 123 تونس 4567 or 12 تونس 3456
    private const string STANDARD_REGEX = '/^(\d{2,3})\s+(تونس)\s+(\d{4})$/u';

    // Format: RS 123 تونس or RS 12 تونس
    private const string SPECIAL_REGEX = '/^(RS)\s+(\d{2,3})\s+(تونس)$/u';

    // Format: standard OR special
    private const string ANY_REGEX = '/^((\d{2,3})\s+(تونس)\s+(\d{4}))|((RS)\s+(\d{2,3})\s+(تونس))$/u';

    /**
     * Normalizes a car plate string by:
     * - Trimming whitespace
     * - Uppercasing Latin characters only (for RS prefix; Arabic is left as-is)
     * - Collapsing multiple spaces into one
     */
    private static function normalize(string $carPlate): string
    {
        $uppercased = preg_replace_callback(
            '/[a-z]+/u',
            static fn (array $match): string => strtoupper($match[0]),
            $carPlate,
        );

        $trimmed = trim($uppercased);

        return preg_replace('/\s+/u', ' ', $trimmed);
    }

    /**
     * Strict-mode structural checks shared by validate() and getInfo().
     */
    private static function passesStrictChecks(string $carPlate): bool
    {
        if ($carPlate !== trim($carPlate)) {
            return false;
        }

        if (str_contains($carPlate, '  ')
            || str_contains($carPlate, 'tun')
            || str_contains($carPlate, 'TUN')
        ) {
            return false;
        }

        return str_contains($carPlate, 'تونس');
    }

    public static function validate(
        ?string $carPlate,
        CarPlateType $type = CarPlateType::Any,
        bool $strict = false,
    ): bool {
        if ($carPlate === null || $carPlate === '') {
            return false;
        }

        if ($strict && !self::passesStrictChecks($carPlate)) {
            return false;
        }

        $plateToCheck = $strict ? $carPlate : self::normalize($carPlate);

        $regex = match ($type) {
            CarPlateType::Standard => self::STANDARD_REGEX,
            CarPlateType::Special => self::SPECIAL_REGEX,
            CarPlateType::Any => self::ANY_REGEX,
        };

        return preg_match($regex, $plateToCheck) === 1;
    }

    public static function getInfo(
        ?string $carPlate,
        CarPlateType $type = CarPlateType::Any,
        bool $strict = false,
    ): ?CarPlateInfo {
        if (!self::validate($carPlate, $type, $strict)) {
            return null;
        }

        // $carPlate is guaranteed non-null/non-empty here since validate() passed.
        $plateToCheck = $strict ? $carPlate : self::normalize($carPlate);

        if (preg_match(self::STANDARD_REGEX, $plateToCheck, $matches) === 1) {
            return new CarPlateInfo(
                CarPlateType::Standard,
                [
                    'prefix' => $matches[1],
                    'region' => $matches[2],
                    'suffix' => $matches[3],
                ],
            );
        }

        if (preg_match(self::SPECIAL_REGEX, $plateToCheck, $matches) === 1) {
            return new CarPlateInfo(
                CarPlateType::Special,
                [
                    'prefix' => $matches[1],
                    'number' => $matches[2],
                    'region' => $matches[3],
                ],
            );
        }

        return null;
    }
}