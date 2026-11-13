<?php

declare(strict_types=1);

use App\Models\Tenant;

it('super-admin hasil seeder bisa login lewat halaman masuk', function () {
    $email = config('seeding.super_admin.email');
    $password = config('seeding.super_admin.password');

    if (blank($email) || blank($password)) {
        $this->markTestSkipped('SUPER_ADMIN_EMAIL / SUPER_ADMIN_PASSWORD belum diisi.');
    }

    $this->seed();

    $this->post('http://platform.test/login', [
        'email' => $email,
        'password' => $password,
    ])->assertRedirect('/platform');

    $this->assertAuthenticated();
});

it('admin tenant hasil seeder bisa login pada host tenant', function () {
    $email = config('seeding.msva.admin_email');
    $password = config('seeding.msva.admin_password');

    if (blank($email) || blank($password)) {
        $this->markTestSkipped('MSVA_ADMIN_EMAIL / MSVA_ADMIN_PASSWORD belum diisi.');
    }

    Tenant::factory()->create(['slug' => 'msva']);

    $this->seed();

    $this->post('http://msva.platform.test/login', [
        'email' => $email,
        'password' => $password,
    ])->assertRedirect('/admin');

    $this->assertAuthenticated();
});
