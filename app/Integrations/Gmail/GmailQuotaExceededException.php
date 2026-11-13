<?php

declare(strict_types=1);

namespace App\Integrations\Gmail;

use RuntimeException;

final class GmailQuotaExceededException extends RuntimeException
{
    public static function forLimit(int $limit): self
    {
        return new self("Kuota harian Gmail telah habis ({$limit} email).");
    }
}
