<?php

use App\Domain\Tenancy\TenantContext;
use App\Exceptions\TenantContextMissingException;
use App\Models\Tenant;
use App\Models\TenantSettings;

it('menolak query tanpa konteks tenant secara eksplisit', function () {
    TenantSettings::query()->count();
})->throws(TenantContextMissingException::class);

it('hanya mengembalikan data tenant aktif pada konteks', function () {
    $tenantA = Tenant::factory()->create(['slug' => 'msva']);
    $tenantB = Tenant::factory()->create(['slug' => 'demo']);

    TenantSettings::factory()->create(['tenant_id' => $tenantA->getKey()]);
    TenantSettings::factory()->create(['tenant_id' => $tenantB->getKey()]);

    app(TenantContext::class)->set($tenantA);

    expect(TenantSettings::query()->count())->toBe(1)
        ->and(TenantSettings::withoutTenantScope()->count())->toBe(2);
});

it('mengisi tenant_id otomatis dari konteks saat membuat data', function () {
    $tenant = Tenant::factory()->create(['slug' => 'msva']);
    app(TenantContext::class)->set($tenant);

    $settings = TenantSettings::query()->create([
        'bank_accounts' => [],
        'origin' => [],
        'active_couriers' => [],
        'flat_rates' => [],
        'business_hours' => [],
    ]);

    expect($settings->tenant_id)->toBe($tenant->getKey());
});
