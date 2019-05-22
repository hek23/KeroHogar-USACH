<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\SeedDatabase;
use Tests\Traits\SeedDatabaseState;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase, SeedDatabase;

    public function setUp(): void
    {
        parent::setUp();
        SeedDatabaseState::$seeders = [\TownsTableSeeder::class];
        $this->seedDatabase();
    }

    protected function signIn($user = null)
    {
        // use passed in user or create one
        $user = $user ?: create('Appe\User');
        $this->actingAs($user);
        return $this;
    }
}