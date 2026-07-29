<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Formatters;

use AmineZhioua\DegachePhp\Constants\Locale;
use DateTimeInterface;
use IntlDateFormatter;
use RuntimeException;

final class DateFormatter
{
    /**
     * Formats a date according to Tunisian locale.
     * Defaults to IntlDateFormatter::LONG (e.g. "15 جانفي 2024")
     *
     * Use IntlDateFormatter::FULL for weekday-inclusive output
     * (e.g. "الاثنين، 15 جانفي 2024").
     */
    public static function format(
        DateTimeInterface $date,
        int $dateType = IntlDateFormatter::LONG,
        int $timeType = IntlDateFormatter::NONE
    ): string {
        $formatter = new IntlDateFormatter(
            Locale::DEFAULT,
            $dateType,
            $timeType,
        );

        $formatted = $formatter->format($date);

        if ($formatted === false) {
            throw new RuntimeException('Failed to format date.');
        }

        return $formatted;
    }
}