<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\PlanCode;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Plan>
 */
final class PlanFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'code' => PlanCode::Free,
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
    }

    public function plan(): static
    {
        return $this->state(fn (): array => [
            'code' => PlanCode::Plan,
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
        ]);
    }
}
