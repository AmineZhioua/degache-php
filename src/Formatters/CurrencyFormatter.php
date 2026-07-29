<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Formatters;

use AmineZhioua\DegachePhp\Constants\Locale;
use NumberFormatter;

final class CurrencyFormatter
{
    /**
     * Formats a monetary amount in Tunisian Dinar.
     *
     * @param float $amount The amount to format.
     * @param bool $code When true, displays the ISO currency code (e.g. "TND"). Takes precedence over $symbol.
     * @param bool $symbol When true, displays the currency symbol (e.g. "د.ت").
     *                      If neither is set, the full currency name is displayed.
     */
    public static function format(float $amount, bool $code = false, bool $symbol = false): string
    {
        $formatter = new NumberFormatter(Locale::DEFAULT, NumberFormatter::CURRENCY);

        // ICU currency patterns use repeated "¤" to select display style:
        // ¤ = symbol, ¤¤ = ISO code, ¤¤¤ = full currency name.
        $displayToken = match (true) {
            $code => '¤¤',
            $symbol => '¤',
            default => '¤¤¤',
        };

        $pattern = preg_replace('/¤+/', $displayToken, $formatter->getPattern());
        $formatter->setPattern($pattern);

        $formatted = $formatter->formatCurrency($amount, 'TND');

        if ($formatted === false) {
            throw new \RuntimeException('Failed to format currency amount.');
        }

        return $formatted;
    }
}