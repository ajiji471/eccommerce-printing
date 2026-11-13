<?php

use App\Enums\PlanCode;
use App\Models\Plan;
use App\Models\Tenant;
use App\Models\TenantSubscription;

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
