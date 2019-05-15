<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Price;
use Faker\Generator as Faker;
use App\Product;

$factory->define(Price::class, function (Faker $faker) {
    return [
        'product_id' => Product::inRandomOrder()->first()->id,
        'price' => $faker->numberBetween(500, 8000),
        'wholesaler' => $faker->boolean(),
    ];
});
