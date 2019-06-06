<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Order;
use App\Address;
use App\Town;
use App\User;
use App\Product;
use App\ProductFormat;

class OrderValidationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->signIn(create(User::class, [
            'role' => User::ADMIN,
        ]));
        $this->product = create(Product::class, [
            'name' => 'Parafina',
            'price' => 748,
            'wholesaler_price' => 648,
            'is_compounded' => true,
        ]);
        $this->format = create(ProductFormat::class, [
            'product_id' => $this->product->id,
            'name' => 'Parafina + bidón',
            'added_price' => 1000,
            'capacity' => 20,
            'minimum_quantity' => 40,
        ]);

        $this->town = get_random(Town::class);
        $this->address = create(Address::class, [
            'town_id' => $this->town->id,
            'address' => 'Calle Marina De Gaete, 781',
        ]);
    }

    /** @test */
    function it_requires_a_product()
    {
        $this->validateOrder(['product' => ''])
            ->assertSessionHasErrors('product');
    }

    /** @test */
    function it_requires_quantity()
    {
        $this->validateOrder(['quantity' => ''])
            ->assertSessionHasErrors('quantity');
    }

    /** @test */
    function it_requires_delivery_status()
    {
        $this->validateOrder(['delivery_status' => ''])
            ->assertSessionHasErrors('delivery_status');
    }

    /** @test */
    function it_requires_payment_status()
    {
        $this->validateOrder(['payment_status' => ''])
            ->assertSessionHasErrors('payment_status');
    }

    /** @test */
    function it_requires_delivery_date()
    {
        $this->validateOrder(['delivery_date' => ''])
            ->assertSessionHasErrors('delivery_date');
    }

    /** @test */
    function it_requires_a_delivery_time()
    {
        $this->validateOrder(['delivery_time' => ''])
            ->assertSessionHasErrors('delivery_time');
    }

    /** @test */
    function it_requires_a_client_name()
    {
        $this->validateOrder(['name' => ''])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    function it_requires_a_town()
    {
        $this->validateOrder(['town' => ''])
            ->assertSessionHasErrors('town');
    }

    /** @test */
    function it_requires_an_address()
    {
        $this->validateOrder(['address' => ''])
            ->assertSessionHasErrors('address');
    }

    /** @test */
    function it_will_let_the_user_create_a_new_order_when_valid_data_is_given()
    {
        $this->assertEquals(0, Order::count());

        $this->validateOrder()->assertSessionDoesntHaveErrors();
        
        $this->assertEquals(1, Order::count());
    }
    
    /** @test */
    function it_will_create_a_new_address_when_given_address_is_not_in_database()
    {
        $this->assertEquals(1, Address::count());

        $this->validateOrder(['address' => 'New address 245'])
            ->assertSessionDoesntHaveErrors();

        $this->assertEquals(2, Address::count());
    }

    /** @test */
    function it_wont_create_a_new_address_when_given_address_is_in_database()
    {
        $this->assertEquals(1, Address::count());
        $this->validateOrder()->assertSessionDoesntHaveErrors();
        $this->assertEquals(1, Address::count());
    }

    /** @test */
    function after_creating_an_order_it_should_appear_in_orders_index()
    {
        $this->get('/pedidos')
            ->assertStatus(200)
            ->assertSee(__('navigation.orders.empty'));

        $this->validateOrder()->assertSessionDoesntHaveErrors();

        $this->get('/pedidos')
            ->assertStatus(200)
            ->assertSee(Order::first()->productNameFormat());
    }

    protected function validateOrder($attributes = [])
    {
        $this->withExceptionHandling();

        return $this->post('/pedidos', $this->validFields($attributes));
    }

    /**
     * @param array $overrides
     * @return array
     */
    protected function validFields($overrides = [])
    {
        return array_merge([
            'product' => $this->product->id,
            'format' => $this->format->id,
            'quantity' => 200,
            'delivery_status' => Order::PENDING_DELIVERY,
            'payment_status' => Order::PENDING_PAYMENT,
            'delivery_date' => '2019-05-22',
            'delivery_time' => [1, 2, 3, 4],
            'rut' => '19.323.425-9',
            'name' => 'Cristian Suarez',
            'email' => 'critsan_1973@yahoo.nope',
            'phone' => '123456789',
            'wholesaler' => true,
            'town' => $this->town->id,
            'address' => 'Calle Marina De Gaete, 781',
        ], $overrides);
    }
}
