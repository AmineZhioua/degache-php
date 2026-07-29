<?php

declare(strict_types=1);

namespace AmineZhioua\DegachePhp\Enums;

enum CarPlateType: string
{
    case Standard = 'standard';
    case Special = 'special';
    case Any = 'any';
}