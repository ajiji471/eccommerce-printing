<?php

declare(strict_types=1);

namespace Tests\Concerns;

use App\Models\Tenant;

trait UsesTenantHost
{
    protected function bootTenantHost(string $slug = 'msva'): Tenant
    {
        $tenant = Tenant::factory()->create(['slug' => $slug]);

        $this->withServerVariables(['HTTP_HOST' => $slug.'.'.config('app.platform_domain')]);

        return $tenant;
    }
}
