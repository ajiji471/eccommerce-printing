<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('seeding.super_admin.email');
        $password = config('seeding.super_admin.password');

        if ($email === null || $password === null) {
            $this->command?->warn('Super-admin dilewati: isi SUPER_ADMIN_EMAIL dan SUPER_ADMIN_PASSWORD di .env.');

            return;
        }

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => config('seeding.super_admin.name'),
                'password' => Hash::make($password),
                'email_verified_at' => now(),
                'is_super_admin' => true,
            ]
        );
    }
}
