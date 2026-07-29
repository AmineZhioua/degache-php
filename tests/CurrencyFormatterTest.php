<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Tests;

use AmineZhioua\DegachePhp\Formatters\CurrencyFormatter;
use PHPUnit\Framework\TestCase;


#[CoversClass(CurrencyFormatter::class)]
final class CurrencyFormatterTest extends TestCase
{
    public function testFormatsWithDefaultOptions(): void
    {
        $formatted = CurrencyFormatter::format(1234.56);

        self::assertStringContainsString('1.234,560', $formatted);
        self::assertStringContainsString('دينار تونسي', $formatted);
    }

    public function testFormatsWithSymbolOption(): void
    {
        $formatted = CurrencyFormatter::format(1234.56, symbol: true);

        self::assertStringContainsString('د.ت', $formatted);
    }

    public function testFormatsWithCodeOption(): void
    {
        $formatted = CurrencyFormatter::format(1234.56, code: true);

        self::assertStringContainsString('TND', $formatted);
    }

    public function testFormatsZeroAmountCorrectly(): void
    {
        $formatted = CurrencyFormatter::format(0);

        self::assertStringContainsString('0,000', $formatted);
        self::assertStringContainsString('دينار تونسي', $formatted);
    }

    public function testFormatsNegativeAmountsCorrectly(): void
    {
        $formatted = CurrencyFormatter::format(-500.75);

        self::assertStringContainsString('500,750', $formatted);
        self::assertStringContainsString('دينار تونسي', $formatted);
    }

    public function testFormatsLargeAmountsWithProperSeparators(): void
    {
        $formatted = CurrencyFormatter::format(1000000.99);

        self::assertStringContainsString('1.000.000,990', $formatted);
    }

    public function testCodeTakesPrecedenceOverSymbol(): void
    {
        $formatted = CurrencyFormatter::format(100, code: true, symbol: true);

        self::assertStringContainsString('TND', $formatted);
        self::assertStringNotContainsString('د.ت', $formatted);
    }
}