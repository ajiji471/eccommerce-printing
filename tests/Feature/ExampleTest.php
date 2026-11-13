<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_platform_landing_page_is_served_on_the_platform_domain()
    {
        $response = $this->get('http://'.config('app.platform_domain').'/');

        $response->assertOk();
    }
}
