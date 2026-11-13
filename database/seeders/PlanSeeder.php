<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\PlanCode;
use App\Models\Plan;
use Illuminate\Database\Seeder;

final class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $free = [
            'name' => 'FREE',
            'max_orders_per_month' => 10,
            'max_products' => 20,
            'max_admins' => 1,
            'storage_quota_mb' => 2048,
            'features' => [
                'midtrans' => false,
                'csv_export' => false,
                'custom_domain' => false,
                'own_branding' => false,
            ],
            'price' => null,
        ];

        $plan = [
            'name' => 'PLAN',
            'max_orders_per_month' => null,
            'max_products' => null,
            'max_admins' => 5,
            'storage_quota_mb' => 20480,
            'features' => [
                'midtrans' => true,
                'csv_export' => true,
                'custom_domain' => true,
                'own_branding' => true,
            ],
            'price' => null,
        ];

        Plan::query()->updateOrCreate(['code' => PlanCode::Free->value], $free);
        Plan::query()->updateOrCreate(['code' => PlanCode::Plan->value], $plan);
    }
}
