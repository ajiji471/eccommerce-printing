<?php

use App\Enums\PlanCode;
use App\Models\Plan;
use App\Models\Tenant;
use App\Models\TenantSubscription;
use App\Models\TenantUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('melewati super-admin saat kredensial di konfigurasi kosong', function () {
    config([
        'seeding.super_admin.email' => '',
        'seeding.super_admin.password' => '',
    ]);

    $this->seed();

    expect(User::query()->where('is_super_admin', true)->exists())->toBeFalse();
});

it('membuat super-admin dari kredensial konfigurasi', function () {
    config([
        'seeding.super_admin.email' => 'super@example.test',
        'seeding.super_admin.password' => 'rahasia-uji',
    ]);

    $this->seed();

    $admin = User::query()->where('email', 'super@example.test')->firstOrFail();

    expect($admin->is_super_admin)->toBeTrue()
        ->and(Hash::check('rahasia-uji', $admin->password))->toBeTrue();
});

it('melewati admin tenant saat kredensial di konfigurasi kosong', function () {
    config([
        'seeding.msva.admin_email' => '',
        'seeding.msva.admin_password' => '',
        'seeding.demo.admin_email' => '',
        'seeding.demo.admin_password' => '',
    ]);

    $this->seed();

    expect(TenantUser::query()->count())->toBe(0);
});

it('menjalankan seeder dua kali tanpa membuat duplikasi', function () {
    $this->seed();
    $this->seed();

    expect(Plan::query()->count())->toBe(2)
        ->and(Tenant::query()->count())->toBe(2)
        ->and(TenantSubscription::query()->count())->toBe(2);
});

it('menyimpan batas paket FREE sebagai data', function () {
    $this->seed();

    $free = Plan::query()->where('code', PlanCode::Free->value)->firstOrFail();

    expect($free->max_orders_per_month)->toBe(10)
        ->and($free->max_products)->toBe(20)
        ->and($free->max_admins)->toBe(1);
});

it('memberi paket PLAN tanpa batas pesanan dan produk pada tenant MSVA', function () {
    $this->seed();

    $tenant = Tenant::query()->where('slug', 'msva')->firstOrFail();
    $plan = $tenant->currentPlan();

    expect($plan)->not->toBeNull()
        ->and($plan->code)->toBe(PlanCode::Plan)
        ->and($plan->max_orders_per_month)->toBeNull()
        ->and($plan->max_products)->toBeNull();
});
