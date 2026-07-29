<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Formatters;

use AmineZhioua\DegachePhp\Constants\Locale;
use DateTimeInterface;
use IntlDateFormatter;

final class DateFormatter
{
    /**
     * Formats a date according to Tunisian locale.
     *
     * Defaults to long-form date (e.g. "٢٩ جويلية ٢٠٢٦"): numeric year,
     * long month name, numeric day — matching degachejs's default options
     * ({ year: "numeric", month: "long", day: "numeric" }).
     */
    public static function format(
        DateTimeInterface $date,
        int $dateType = IntlDateFormatter::LONG,
        int $timeType = IntlDateFormatter::NONE,
    ): string {
        $formatter = new IntlDateFormatter(
            Locale::DEFAULT,
            $dateType,
            $timeType,
        );

        $formatted = $formatter->format($date);

        if ($formatted === false) {
            throw new \RuntimeException('Failed to format date.');
        }

        return $formatted;
    }
}