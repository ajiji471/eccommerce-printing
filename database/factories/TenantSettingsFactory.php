<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Tenant;
use App\Models\TenantSettings;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TenantSettings>
 */
final class TenantSettingsFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'bank_accounts' => [],
            'origin' => [
                'province_id' => '32',
                'city_id' => '3273',
                'district_id' => null,
                'postal_code' => '40111',
            ],
            'active_couriers' => ['jne', 'pos', 'tiki'],
            'flat_rates' => [],
            'ppn_percent' => 11.00,
            'business_hours' => [],
        ];
    }
}
