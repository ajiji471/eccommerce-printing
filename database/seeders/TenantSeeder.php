<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\PlanCode;
use App\Enums\Role;
use App\Enums\TenantStatus;
use App\Models\Plan;
use App\Models\Tenant;
use App\Models\TenantSettings;
use App\Models\TenantSubscription;
use App\Models\TenantUser;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedTenant(
            [
                'name' => 'MSVA Grafika',
                'display_name' => 'MSVA Grafika',
                'slug' => 'msva',
                'status' => TenantStatus::Active,
                'accent_color' => '#E4574C',
                'address' => 'Jl. Contoh No. 1, Yogyakarta',
                'contact' => [
                    'phone' => '0274-000000',
                    'email' => 'halo@msva.test',
                ],
                'footer' => 'MSVA Grafika — percetakan cepat dan terpercaya.',
            ],
            PlanCode::Plan,
            config('seeding.msva.admin_name'),
            config('seeding.msva.admin_email'),
            config('seeding.msva.admin_password'),
        );

        $this->seedTenant(
            [
                'name' => 'Demo Print',
                'display_name' => 'Demo Print',
                'slug' => 'demo',
                'status' => TenantStatus::Active,
                'accent_color' => '#0E1B2A',
                'address' => 'Jl. Demo No. 2, Yogyakarta',
                'contact' => [
                    'phone' => '0274-111111',
                    'email' => 'halo@demo.test',
                ],
                'footer' => 'Demo Print — tenant uji isolasi data.',
            ],
            PlanCode::Free,
            config('seeding.demo.admin_name'),
            config('seeding.demo.admin_email'),
            config('seeding.demo.admin_password'),
        );
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function seedTenant(
        array $attributes,
        PlanCode $planCode,
        ?string $adminName,
        ?string $adminEmail,
        ?string $adminPassword,
    ): void {
        $tenant = Tenant::query()->updateOrCreate(
            ['slug' => $attributes['slug']],
            $attributes
        );

        TenantSettings::withoutTenantScope()->firstOrCreate(
            ['tenant_id' => $tenant->id],
            [
                'bank_accounts' => [],
                'origin' => [
                    'province_id' => '34',
                    'city_id' => '3471',
                    'district_id' => null,
                    'postal_code' => '55223',
                ],
                'active_couriers' => ['jne', 'pos', 'tiki'],
                'flat_rates' => [],
                'ppn_percent' => 11.00,
                'business_hours' => [],
            ]
        );

        $plan = Plan::query()->where('code', $planCode->value)->firstOrFail();

        TenantSubscription::query()->updateOrCreate(
            ['tenant_id' => $tenant->id, 'status' => 'active'],
            [
                'plan_id' => $plan->id,
                'starts_at' => now(),
                'ends_at' => null,
            ]
        );

        if ($adminEmail === null || $adminPassword === null) {
            $this->command?->warn("Admin untuk tenant {$tenant->slug} dilewati: isi MSVA_ADMIN_* / DEMO_ADMIN_* di .env.");

            return;
        }

        $admin = User::query()->updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => $adminName ?? $tenant->display_name,
                'password' => Hash::make($adminPassword),
                'email_verified_at' => now(),
            ]
        );

        TenantUser::query()->updateOrCreate(
            ['tenant_id' => $tenant->id, 'user_id' => $admin->id],
            ['role' => Role::Admin->value]
        );
    }
}
