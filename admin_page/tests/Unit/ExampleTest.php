<?php

namespace Tests\Unit;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    function redirects_to_login()
    {
        $response = $this->get('/');
        $response->assertStatus(302);
    }
}
