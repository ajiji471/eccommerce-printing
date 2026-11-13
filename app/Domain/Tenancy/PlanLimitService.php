<?php

declare(strict_types=1);

namespace App\Domain\Tenancy;

use App\Enums\PlanCode;
use App\Models\Plan;
use App\Models\Tenant;

final class PlanLimitService
{
    public function planFor(Tenant $tenant): ?Plan
    {
        return $tenant->activeSubscription()->with('plan')->first()?->plan;
    }

    public function allows(Tenant $tenant, string $feature): bool
    {
        $plan = $this->planFor($tenant);

        if ($plan === null) {
            return false;
        }

        return $plan->hasFeature($feature);
    }

    public function codeFor(Tenant $tenant): PlanCode
    {
        $plan = $this->planFor($tenant);

        return $plan === null ? PlanCode::Free : $plan->code;
    }

    public function limit(Tenant $tenant, string $key): ?int
    {
        $plan = $this->planFor($tenant);

        if ($plan === null) {
            return null;
        }

        $value = $plan->getAttribute($key);

        return is_numeric($value) ? (int) $value : null;
    }
}
