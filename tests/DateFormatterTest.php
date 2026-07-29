<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Tests;

use AmineZhioua\DegachePhp\Formatters\DateFormatter;
use DateTimeImmutable;
use IntlDateFormatter;
use PHPUnit\Framework\TestCase;

#[CoversClass(DateFormatter::class)]
final class DateFormatterTest extends TestCase
{
    public function testFormatsDateWithDefaultOptions(): void
    {
        $date = new DateTimeImmutable('2024-01-15');

        self::assertSame('15 جانفي 2024', DateFormatter::format($date));
    }

    public function testFormatsDifferentMonthCorrectly(): void
    {
        $date = new DateTimeImmutable('2024-07-04');

        self::assertSame('4 جويلية 2024', DateFormatter::format($date));
    }

    public function testFormatsWithWeekdayUsingFullPreset(): void
    {
        $date = new DateTimeImmutable('2024-01-15'); // a Monday

        self::assertSame(
            'الاثنين، 15 جانفي 2024',
            DateFormatter::format($date, IntlDateFormatter::FULL),
        );
    }
}