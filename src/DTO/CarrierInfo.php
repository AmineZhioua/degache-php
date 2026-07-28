<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\DTO;

final readonly class CarrierInfo
{
    /**
     * @param string[] $prefixes
     */
    public function __construct(
        public string $name,
        public array $prefixes,
    ) {
    }
}