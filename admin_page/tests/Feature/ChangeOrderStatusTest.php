<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Order;
use App\User;

class ChangeOrderStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function user_can_change_delivery_status_from_pending_to_delivered()
    {
        $this->signIn(create(User::class, [
            'role' => User::ADMIN,
        ]));

        $order = create(Order::class, [
            'delivery_status' => Order::PENDING_DELIVERY,
        ]);
        $this->assertTrue($order->delivery_status === Order::PENDING_DELIVERY);
        
        $response = $this->post('pedidos/' . $order->id . '/entregado');
        $response->assertStatus(302);
        
        $order = Order::first();
        $this->assertTrue($order->delivery_status === Order::DELIVERED);
    }

    /** @test */
    function user_can_change_payment_status_from_pending_to_paid()
    {
        $this->signIn(create(User::class, [
            'role' => User::ADMIN,
        ]));

        $order = create(Order::class, [
            'payment_status' => Order::PENDING_PAYMENT,
        ]);
        $this->assertTrue($order->payment_status === Order::PENDING_PAYMENT);

        $response = $this->post('pedidos/' . $order->id . '/pagado');
        $response->assertStatus(302);

        $order = Order::first();
        $this->assertTrue($order->payment_status === Order::PAID);
    }
}
