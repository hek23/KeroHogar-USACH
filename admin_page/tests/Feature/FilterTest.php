<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Order;
use App\Address;
use App\Town;

class FilterTest extends TestCase
{
    use RefreshDatabase;

    const FILTER_URI = '/pedidos?';

    /** @test */
    function empty_filter_by_time_interval()
    {
        $this->signIn($cristian = create(User::class));

        $response = $this->get($this->buildSearchUrl([
            'time_interval_start' => '2019-05-05',
            'time_interval_end' => '2019-06-05',
        ]));
        $response->assertStatus(200);
        $response->assertSee(__('navigation.orders.empty'));
    }

    /** @test */
    function pagination_in_filter_by_time_interval()
    {
        $this->signIn($cristian = create(User::class));
        factory(Order::class, 2 * Order::ITEMS_PER_PAGE)->create([
            'delivery_date' => '2019-05-08',
        ]);
        create_product_for_orders();

        $response = $this->get($this->buildSearchUrl([
            'time_interval_start' => '2019-05-05',
            'time_interval_end' => '2019-06-05',
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder(['&lsaquo;', '1', '2', '>&rsaquo;']);
    }

    /** @test */
    function view_orders_in_filter_by_time_interval()
    {
        $this->signIn($cristian = create(User::class));
        factory(Order::class, Order::ITEMS_PER_PAGE)->create([
            'delivery_date' => '2019-05-08',
        ]);
        create_product_for_orders();
        
        $orders = Order::all()->map(function($order) {return $order->productNameFormat();});

        $response = $this->get($this->buildSearchUrl([
            'time_interval_start' => '2019-05-05',
            'time_interval_end' => '2019-06-05',
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder($orders->toArray());
    }

    /** @test */
    function empty_filter_by_town()
    {
        $this->signIn($cristian = create(User::class));

        $response = $this->get($this->buildSearchUrl([
            'town_id' => Town::first()->id,
        ]));
        $response->assertStatus(200);
        $response->assertSee(__('navigation.orders.empty'));
    }

    /** @test */
    function pagination_in_filter_by_town()
    {
        $this->signIn($cristian = create(User::class));
        factory(Order::class, 2 * Order::ITEMS_PER_PAGE)->create([
            'address_id' => create(Address::class, [
                'town_id' => Town::first()->id,
            ]),
        ]);
        create_product_for_orders();

        $response = $this->get($this->buildSearchUrl([
            'town_id' => Town::first()->id,
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder(['&lsaquo;', '1', '2', '>&rsaquo;']);
    }

    /** @test */
    function view_orders_in_filter_by_town()
    {
        $this->signIn($cristian = create(User::class));
        factory(Order::class, Order::ITEMS_PER_PAGE)->create([
            'address_id' => create(Address::class, [
                'town_id' => Town::first()->id,
            ]),
        ]);
        create_product_for_orders();
        
        $orders = Order::all()->map(function($order) {return $order->productNameFormat();});

        $response = $this->get($this->buildSearchUrl([
            'town_id' => Town::first()->id,
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder($orders->toArray());
    }

    protected function buildSearchUrl($overrides = [])
    {
        $attributes = array_merge([
            'client_type' => '0',
            'time_interval_start' => '',
            'time_interval_end' => '',
            'time_block_id' => '0',
            'town_id' => '0',
            'delivery_status' => '0',
            'payment_status' => '0',
        ], $overrides);

        return self::FILTER_URI . 'client_type=' . $attributes['client_type'] . 
            '&time_interval_start=' . $attributes['time_interval_start'] .
            '&time_interval_end=' . $attributes['time_interval_end'] .
            '&time_block_id=' . $attributes['time_block_id'] .
            '&town_id=' . $attributes['town_id'] .
            '&delivery_status=' . $attributes['delivery_status'] .
            '&payment_status=' . $attributes['payment_status']. 
            '&page=1';
    }
}
