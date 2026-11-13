<?php

use App\Enums\Role;
use App\Models\Tenant;
use App\Models\TenantUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature');

pest()->extend(TestCase::class)->in('Unit');

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

function withTenantHost(Tenant $tenant): string
{
    return $tenant->slug.'.'.config('app.platform_domain');
}

function actingAsTenantAdmin(Tenant $tenant): User
{
    $user = User::factory()->create(['email_verified_at' => now()]);

    TenantUser::query()->create([
        'tenant_id' => $tenant->getKey(),
        'user_id' => $user->getKey(),
        'role' => Role::Admin->value,
    ]);

    test()->actingAs($user);

    return $user;
}

function actingAsBuyer(Tenant $tenant): User
{
    $user = User::factory()->create(['email_verified_at' => now()]);

    TenantUser::query()->create([
        'tenant_id' => $tenant->getKey(),
        'user_id' => $user->getKey(),
        'role' => Role::Pembeli->value,
    ]);

    test()->actingAs($user);

    return $user;
}

function actingAsSuperAdmin(): User
{
    $user = User::factory()->superAdmin()->create(['email_verified_at' => now()]);

    test()->actingAs($user);

    return $user;
}
