<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\UsesTenantHost;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;
    use UsesTenantHost;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bootTenantHost();
    }

    public function test_guests_are_redirected_to_the_login_page()
    {
        $this->get('/akun')->assertRedirect('/login');
    }

    public function test_authenticated_users_can_visit_the_account_dashboard()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/akun')
            ->assertOk();
    }
}
