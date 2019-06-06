<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\TimeBlock;
use App\User;

class TimeBlockValidationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {   
        parent::setUp();

        $this->signIn(create(User::class, [
            'role' => User::ADMIN,
        ]));
    }

    /** @test */
    function it_will_throw_an_error_if_it_intersects_with_another_time_block()
    {
        create(TimeBlock::class, [
            'start' => '08:00',
            'end' => '13:00',
        ]);
        $this->validateTimeBlock([
                'start' => '12:00',
                'end' => '18:00',
            ])
            ->assertSessionHasErrors([
                'start' => 'El bloque ingresado intersecta con el horario de algún otro bloque.'
            ]);
    }

    /** @test */
    function it_will_let_time_blocks_overlap()
    {
        create(TimeBlock::class, [
            'start' => '08:00',
            'end' => '13:00',
        ]);
        $this->validateTimeBlock([
                'start' => '13:00',
                'end' => '18:00',
            ])
            ->assertSessionDoesntHaveErrors();
    }

    /** @test */
    function it_will_not_accept_incoherent_time_interval_for_the_block()
    {
        $this->validateTimeBlock([
                'start' => '13:00',
                'end' => '08:00',
            ])
            ->assertSessionHasErrors('end');
    }

    protected function validateTimeBlock($attributes = [])
    {
        $this->withExceptionHandling();

        return $this->post('/horario', $this->validFields($attributes));
    }

    /**
     * @param array $overrides
     * @return array
     */
    protected function validFields($overrides = [])
    {
        return array_merge([
            'max_orders' => 20,
            'start' => '08:00',
            'end' => '11:00',
        ], $overrides);
    }
}
