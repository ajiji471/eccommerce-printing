<?php

declare(strict_types=1);

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Pembeli = 'pembeli';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Pembeli => 'Pembeli',
        };
    }
}
