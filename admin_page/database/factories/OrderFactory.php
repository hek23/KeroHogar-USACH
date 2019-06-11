<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Order;
use Faker\Generator as Faker;
use App\Address;

$factory->define(Order::class, function (Faker $faker) {
    $deliveryDate = $faker->dateTimeBetween('-1 days', '+2 days');
    if($deliveryDate < now()) {
        $delivery_status = Order::DELIVERED;
        $payment_status = Order::PAID;
    } else {
        $delivery_status = Order::PENDING_DELIVERY;
        $payment_status = $faker->numberBetween(1, 2);
    }

    return [
        'address_id' => function(){
            $address = Address::inRandomOrder()->first();
            if($address === null) {
                return factory(Address::class)->create()->id;
            } else {
                return $address->id;
            }
        },
        'delivery_status' => $delivery_status,
        'payment_status' => $payment_status,
        'amount' => $faker->numberBetween(10000, 100000),
        'delivery_date' => $deliveryDate,
    ];
});
