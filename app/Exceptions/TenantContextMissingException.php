<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

final class TenantContextMissingException extends RuntimeException
{
    public static function for(string $subject): self
    {
        return new self("Konteks tenant belum ditetapkan saat mengakses {$subject}. Pastikan ResolveTenant berjalan atau TenantContext diisi.");
    }
}
