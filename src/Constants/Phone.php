<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Constants;

final class Phone
{
    public const string COUNTRY_CODE = '+216';

    /**
     * @var array<string, array{name: string, prefixes: string[]}>
     */
    public const array CARRIERS = [
        'OOREDOO' => [
            'name' => 'Ooredoo Tunisia',
            'prefixes' => ['2', '5'],
        ],
        'ORANGE' => [
            'name' => 'Orange Tunisia',
            'prefixes' => ['4', '5'],
        ],
        'TELECOM' => [
            'name' => 'Tunisie Telecom',
            'prefixes' => ['2', '9'],
        ],
    ];

    /**
     * All unique valid mobile prefixes across carriers.
     *
     * @return string[]
     */
    public static function validPrefixes(): array
    {
        $prefixes = [];

        foreach (self::CARRIERS as $carrier) {
            foreach ($carrier['prefixes'] as $prefix) {
                $prefixes[$prefix] = $prefix;
            }
        }

        return array_values($prefixes);
    }
}