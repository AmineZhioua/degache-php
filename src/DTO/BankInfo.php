<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\DTO;

final readonly class BankInfo
{
    public function __construct(
        public string $code,
        public string $name,
    ) {
    }
}