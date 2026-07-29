<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\DTO;

use AmineZhioua\DegachePhp\Enums\CarPlateType;

final readonly class CarPlateInfo
{
    /**
     * @param CarPlateType $type Either Standard or Special (never Any — that's a query filter, not a result type)
     * @param array<string, string> $components e.g. ['prefix' => '123', 'region' => 'تونس', 'suffix' => '4567']
     */
    public function __construct(
        public CarPlateType $type,
        public array $components,
    ) {
    }
}