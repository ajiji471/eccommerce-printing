<?php

declare(strict_types=1);

namespace App\Integrations\Gmail;

use Illuminate\Support\Facades\Cache;

final class GmailQuota
{
    public function consume(): void
    {
        $limit = (int) config('gmail.daily_quota', 500);
        $key = 'gmail:quota:'.now()->toDateString();

        Cache::add($key, 0, now()->endOfDay());

        $used = (int) Cache::increment($key);

        if ($used > $limit) {
            throw GmailQuotaExceededException::forLimit($limit);
        }
    }

    public function usedToday(): int
    {
        return (int) Cache::get('gmail:quota:'.now()->toDateString(), 0);
    }
}
