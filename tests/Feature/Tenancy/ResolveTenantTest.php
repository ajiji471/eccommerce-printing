<?php

use App\Models\Tenant;
use Inertia\Testing\AssertableInertia as Assert;

it('memuat tenant yang berbeda berdasarkan subdomain', function () {
    Tenant::factory()->create(['slug' => 'msva']);
    Tenant::factory()->create(['slug' => 'demo']);

    $this->get('http://msva.platform.test/')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->where('tenant.slug', 'msva'));

    $this->get('http://demo.platform.test/')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->where('tenant.slug', 'demo'));
});

it('mencocokkan custom domain sebelum subdomain', function () {
    Tenant::factory()->create([
        'slug' => 'msva',
        'domain' => 'toko-khusus.test',
    ]);

    $this->get('http://toko-khusus.test/')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->where('tenant.slug', 'msva'));
});

it('melayani landing platform pada host lokal', function () {
    Tenant::factory()->create(['slug' => 'msva']);

    $this->get('http://localhost/')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('Platform/Landing'));

    $this->get('http://127.0.0.1/')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('Platform/Landing'));
});

it('mengembalikan 404 untuk host yang tidak dikenal', function () {
    Tenant::factory()->create(['slug' => 'msva']);

    $this->get('http://tidak-dikenal.test/')->assertNotFound();
});

it('menolak spoofing subdomain di luar domain platform', function () {
    Tenant::factory()->create(['slug' => 'msva']);

    $this->get('http://msva.platform.test.evil.com/')->assertNotFound();
});

it('tidak melayani storefront tenant yang ditangguhkan', function () {
    Tenant::factory()->suspended()->create(['slug' => 'msva']);

    $this->get('http://msva.platform.test/')->assertStatus(503);
});

it('menolak admin tenant lain pada panel admin', function () {
    $tenantA = Tenant::factory()->create(['slug' => 'msva']);
    Tenant::factory()->create(['slug' => 'demo']);

    $admin = actingAsTenantAdmin($tenantA);

    $this->get('http://demo.platform.test/admin')->assertForbidden();
});
