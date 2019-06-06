<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use App\Order;
use App\Address;
use App\Town;
use App\Client;
use App\Exports\OrdersExport;

class FilterTest extends TestCase
{
    use RefreshDatabase;

    const FILTER_URI = '/pedidos?';

    /** @test */
    function empty_with_no_filter_given_when_user_role_is_admin()
    {
        $this->signIn(create(User::class, [
            'role' => User::ADMIN,
        ]));

        $response = $this->get('/pedidos');
        $response->assertStatus(200);
        $response->assertSee(__('navigation.orders.empty'));
    }

    /** @test */
    function pagination_with_no_filter_given_when_user_role_is_admin()
    {
        $this->signIn(create(User::class, [
            'role' => User::ADMIN,
        ]));
        factory(Order::class, 2 * Order::ITEMS_PER_PAGE)->create();
        create_product_for_orders();

        $response = $this->get('/pedidos');
        $response->assertStatus(200);
        $response->assertSeeInOrder(['&lsaquo;', '1', '2', '>&rsaquo;']);
    }

    /** @test */
    function view_orders_with_no_filter_given_when_user_role_is_admin()
    {
        $this->signIn(create(User::class, [
            'role' => User::ADMIN,
        ]));
        factory(Order::class, Order::ITEMS_PER_PAGE)->create();
        create_product_for_orders();

        $orders = Order::all()->map(function ($order) {
            return $order->productNameFormat();
        });

        $response = $this->get('/pedidos');
        $response->assertStatus(200);
        $response->assertSeeInOrder($orders->toArray());
    }
    

    /** @test */
    function empty_with_no_filter_given_when_user_role_is_driver()
    {
        $this->signIn(create(User::class, [
            'role' => User::DRIVER,
        ]));

        $response = $this->get('/pedidos');
        $response->assertStatus(200);
        $response->assertSee(__('navigation.orders.empty'));
    }

    /** @test */
    function pagination_with_no_filter_given_when_user_role_is_driver()
    {
        $this->signIn(create(User::class, [
            'role' => User::DRIVER,
        ]));
        factory(Order::class, 2 * Order::ITEMS_PER_PAGE)->create();
        create_product_for_orders();

        $response = $this->get('/pedidos');
        $response->assertStatus(200);
        $response->assertSeeInOrder(['&lsaquo;', '1', '2', '>&rsaquo;']);
    }

    /** @test */
    function view_orders_with_no_filter_given_when_user_role_is_driver()
    {
        $this->signIn(create(User::class, [
            'role' => User::DRIVER,
        ]));
        factory(Order::class, Order::ITEMS_PER_PAGE)->create();
        create_product_for_orders();

        $orders = Order::all()->map(function ($order) {
            return $order->productNameFormat();
        });

        $response = $this->get('/pedidos');
        $response->assertStatus(200);
        $response->assertSeeInOrder($orders->toArray());
    }


    /** @test */
    function empty_filter_by_time_interval()
    {
        $this->signIn(create(User::class));

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
        $this->signIn(create(User::class));
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
        $this->signIn(create(User::class));
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
        $this->signIn(create(User::class));

        $response = $this->get($this->buildSearchUrl([
            'town_id' => Town::first()->id,
        ]));
        $response->assertStatus(200);
        $response->assertSee(__('navigation.orders.empty'));
    }

    /** @test */
    function pagination_in_filter_by_town()
    {
        $this->signIn(create(User::class));
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
        $this->signIn(create(User::class));
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


    /** @test */
    function empty_filter_by_delivery_status_is_pending()
    {
        $this->signIn(create(User::class));

        $response = $this->get($this->buildSearchUrl([
            'delivery_status' => Order::PENDING_DELIVERY,
        ]));
        $response->assertStatus(200);
        $response->assertSee(__('navigation.orders.empty'));
    }

    /** @test */
    function view_orders_in_filter_by_delivery_status_is_pending()
    {
        $this->signIn(create(User::class));
        factory(Order::class, Order::ITEMS_PER_PAGE)->create([
            'delivery_status' => Order::PENDING_DELIVERY,
        ]);
        create_product_for_orders();
        
        $orders = Order::all()->map(function($order) {return $order->productNameFormat();});

        $response = $this->get($this->buildSearchUrl([
            'delivery_status' => Order::PENDING_DELIVERY,
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder($orders->toArray());
    }

    /** @test */
    function empty_filter_by_delivery_status_is_delivered()
    {
        $this->signIn(create(User::class));

        $response = $this->get($this->buildSearchUrl([
            'delivery_status' => Order::DELIVERED,
        ]));
        $response->assertStatus(200);
        $response->assertSee(__('navigation.orders.empty'));
    }

    /** @test */
    function view_orders_in_filter_by_delivery_status_is_delivered()
    {
        $this->signIn(create(User::class));
        factory(Order::class, Order::ITEMS_PER_PAGE)->create([
            'delivery_status' => Order::DELIVERED,
        ]);
        create_product_for_orders();
        
        $orders = Order::all()->map(function($order) {return $order->productNameFormat();});

        $response = $this->get($this->buildSearchUrl([
            'delivery_status' => Order::DELIVERED,
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder($orders->toArray());
    }


    /** @test */
    function empty_filter_by_payment_status_is_pending()
    {
        $this->signIn(create(User::class));

        $response = $this->get($this->buildSearchUrl([
            'payment_status' => Order::PENDING_PAYMENT,
        ]));
        $response->assertStatus(200);
        $response->assertSee(__('navigation.orders.empty'));
    }

    /** @test */
    function view_orders_in_filter_by_payment_status_is_pending()
    {
        $this->signIn(create(User::class));
        factory(Order::class, Order::ITEMS_PER_PAGE)->create([
            'payment_status' => Order::PENDING_PAYMENT,
        ]);
        create_product_for_orders();
        
        $orders = Order::all()->map(function($order) {return $order->productNameFormat();});

        $response = $this->get($this->buildSearchUrl([
            'payment_status' => Order::PENDING_PAYMENT,
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder($orders->toArray());
    }

    /** @test */
    function empty_filter_by_payment_status_is_paid()
    {
        $this->signIn(create(User::class));

        $response = $this->get($this->buildSearchUrl([
            'payment_status' => Order::PAID,
        ]));
        $response->assertStatus(200);
        $response->assertSee(__('navigation.orders.empty'));
    }

    /** @test */
    function view_orders_in_filter_by_payment_status_is_paid()
    {
        $this->signIn(create(User::class));
        factory(Order::class, Order::ITEMS_PER_PAGE)->create([
            'payment_status' => Order::PAID,
        ]);
        create_product_for_orders();
        
        $orders = Order::all()->map(function($order) {return $order->productNameFormat();});

        $response = $this->get($this->buildSearchUrl([
            'payment_status' => Order::PAID,
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder($orders->toArray());
    }


    /** @test */
    function empty_filter_by_client_type_is_particular()
    {
        $this->signIn(create(User::class));

        $response = $this->get($this->buildSearchUrl([
            'client_type' => Client::PARTICULAR,
        ]));
        $response->assertStatus(200);
        $response->assertSee(__('navigation.orders.empty'));
    }

    /** @test */
    function view_orders_in_filter_by_client_type_is_particular()
    {
        $this->signIn(create(User::class));
        $client = create(Client::class, [
            'wholesaler' => false,
        ]);
        factory(Order::class, Order::ITEMS_PER_PAGE)->create([
            'address_id' => create(Address::class,[
                'client_id' => $client->id,
            ]),
        ]);
        create_product_for_orders();
        
        $orders = Order::all()->map(function($order) {return $order->productNameFormat();});

        $response = $this->get($this->buildSearchUrl([
            'client_type' => Client::PARTICULAR,
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder($orders->toArray());
    }

    /** @test */
    function empty_filter_by_client_type_is_wholesaler()
    {
        $this->signIn(create(User::class));

        $response = $this->get($this->buildSearchUrl([
            'client_type' => Client::WHOLESALER,
        ]));
        $response->assertStatus(200);
        $response->assertSee(__('navigation.orders.empty'));
    }

    /** @test */
    function view_orders_in_filter_by_client_type_is_wholesaler()
    {
        $this->signIn(create(User::class));
        $client = create(Client::class, [
            'wholesaler' => true,
        ]);
        factory(Order::class, Order::ITEMS_PER_PAGE)->create([
            'address_id' => create(Address::class, [
                'client_id' => $client->id,
            ]),
        ]);
        create_product_for_orders();
        
        $orders = Order::all()->map(function($order) {return $order->productNameFormat();});

        $response = $this->get($this->buildSearchUrl([
            'client_type' => Client::WHOLESALER,
        ]));
        $response->assertStatus(200);
        $response->assertSeeInOrder($orders->toArray());
    }


    /** @test */
    function downloads_generated_excel_when_there_are_orders_in_filter()
    {
        Excel::fake();
        $this->signIn(create(User::class));
        factory(Order::class, Order::ITEMS_PER_PAGE)->create();
        create_product_for_orders();

        $orders = Order::all()->map(function ($order) {
            return $order->productNameFormat();
        });

        $response = $this->get($this->buildSearchUrl(['generate_excel' => 1]));
        $response->assertStatus(200);

        Excel::assertDownloaded('export.xlsx', function (OrdersExport $export) use ($orders) {
            $collection = $export->collection();
            $containsOrders = true;
            foreach ($orders as $order) {
                $containsOrders = $containsOrders && $collection->contains('Pedido', $order);
            }
            return $containsOrders;
        });
    }

    /** @test */
    function downloads_empty_generated_excel_when_there_are_orders_in_filter()
    {
        Excel::fake();
        $this->signIn(create(User::class));

        $response = $this->get($this->buildSearchUrl(['generate_excel' => 1]));
        $response->assertStatus(200);

        Excel::assertDownloaded('export.xlsx', function (OrdersExport $export) {
            return $export->collection()->isEmpty();
        });
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
            'generate_excel' => '0',
        ], $overrides);

        return self::FILTER_URI . 'client_type=' . $attributes['client_type'] . 
            '&time_interval_start=' . $attributes['time_interval_start'] .
            '&time_interval_end=' . $attributes['time_interval_end'] .
            '&time_block_id=' . $attributes['time_block_id'] .
            '&town_id=' . $attributes['town_id'] .
            '&delivery_status=' . $attributes['delivery_status'] .
            '&payment_status=' . $attributes['payment_status']. 
            '&generate_excel=' . $attributes['generate_excel']. 
            '&page=1';
    }
}
