<?php

declare(strict_types=1);

namespace App\Enums;

enum PlanCode: string
{
    case Free = 'free';
    case Plan = 'plan';

    public function label(): string
    {
        return match ($this) {
            self::Free => 'FREE',
            self::Plan => 'PLAN',
        };
    }
}
