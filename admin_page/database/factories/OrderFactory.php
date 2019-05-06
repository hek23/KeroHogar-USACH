<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Order;
use Faker\Generator as Faker;
use App\Address;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'address_id' => Address::inRandomOrder()->first()->id,
        'status' => $faker->numberBetween(1, 3),
        'amount' => $faker->numberBetween(10000, 100000),
        'delivery_date' => $faker->dateTimeBetween('-5 days', 'now'),
    ];
});
