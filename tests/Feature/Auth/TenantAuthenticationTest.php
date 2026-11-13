<?php

use App\Enums\Role;
use App\Models\Tenant;
use App\Models\TenantUser;
use App\Models\User;

it('mengarahkan admin tenant ke panel admin setelah masuk', function () {
    $tenant = Tenant::factory()->create(['slug' => 'msva']);
    $user = User::factory()->create();

    TenantUser::query()->create([
        'tenant_id' => $tenant->getKey(),
        'user_id' => $user->getKey(),
        'role' => Role::Admin->value,
    ]);

    $this->post('http://msva.platform.test/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect('/admin');

    $this->assertAuthenticatedAs($user);
});

it('mengarahkan pembeli ke halaman akun setelah masuk', function () {
    Tenant::factory()->create(['slug' => 'demo']);
    $user = User::factory()->create();

    $this->post('http://demo.platform.test/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect('/akun');
});

it('membuat relasi pembeli saat registrasi di tenant', function () {
    $tenant = Tenant::factory()->create(['slug' => 'msva']);

    $this->post('http://msva.platform.test/register', [
        'name' => 'Pembeli Baru',
        'email' => 'pembeli@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertRedirect('/akun');

    $user = User::query()->where('email', 'pembeli@example.com')->firstOrFail();

    expect(TenantUser::query()
        ->where('tenant_id', $tenant->getKey())
        ->where('user_id', $user->getKey())
        ->where('role', Role::Pembeli->value)
        ->exists())->toBeTrue();
});

it('menolak login ketika tenant ditangguhkan', function () {
    $tenant = Tenant::factory()->suspended()->create(['slug' => 'msva']);
    $user = User::factory()->create();

    $this->post('http://msva.platform.test/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertStatus(503);

    $this->assertGuest();
});
