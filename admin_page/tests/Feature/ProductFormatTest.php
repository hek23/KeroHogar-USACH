<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\ProductFormat;
use App\Product;
use App\User;

class ProductFormatTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = create(Product::class, [
            'name' => 'Parafina',
            'price' => 748,
            'wholesaler_price' => 648,
            'is_compounded' => true,
        ]);

        $this->signIn(create(User::class, [
            'role' => User::ADMIN,
        ]));
    }

    /** @test */
    function empty_view_with_no_formats_defined()
    {

        $response = $this->get('/productos/' . $this->product->id . '/formatos');
        $response->assertStatus(200);
        $response->assertSee(__('navigation.formats.empty'));
    }

    /** @test */
    function can_add_new_format_and_it_will_appear_in_view()
    {
        $response = $this->get('/productos/' . $this->product->id . '/formatos');
        $response->assertStatus(200);
        $response->assertSee(__('navigation.formats.empty'));

        $response = $this->post('/productos/' . $this->product->id . '/formatos',[
            'name' => 'Parafina + bidón',
            'added_price' => 1000,
            'capacity' => 20,
            'minimum_quantity' => 40,
        ]);

        $response = $this->get('/productos/' . $this->product->id . '/formatos');
        $response->assertStatus(200);
        $response->assertSee(ProductFormat::first()->name);
    }
}
