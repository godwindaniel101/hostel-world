<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class UnauthCase extends BaseTestCase
{
    use CreatesApplication,RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install', ['--no-interaction' => true,]);

         $this->assertTrue(true);
    }
}
