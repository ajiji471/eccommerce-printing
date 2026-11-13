<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        $this->withServerVariables([
            'HTTP_HOST' => (string) config('app.platform_domain'),
        ]);
    }
}
