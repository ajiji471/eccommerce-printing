<?php

declare(strict_types=1);

namespace App\Support;

use App\Domain\Tenancy\TenantContext;
use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

final class AuditLogger
{
    /**
     * @param  array<string, mixed>  $metadata
     */
    public function log(string $action, ?Model $target = null, array $metadata = []): void
    {
        AuditLog::query()->create([
            'tenant_id' => app(TenantContext::class)->idOrNull(),
            'actor_id' => Auth::id(),
            'action' => $action,
            'target_type' => $target?->getMorphClass(),
            'target_id' => $target?->getKey(),
            'metadata' => $metadata,
            'ip' => request()->ip(),
        ]);

        Log::channel('audit')->info($action, [
            'actor_id' => Auth::id(),
            'target_type' => $target?->getMorphClass(),
            'target_id' => $target?->getKey(),
            ...$metadata,
        ]);
    }
}
