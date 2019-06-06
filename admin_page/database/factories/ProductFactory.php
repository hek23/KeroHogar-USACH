<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(4),
        'price' => $faker->numberBetween(100, 500),
        'wholesaler_price' => $faker->numberBetween(100, 500),
        'is_compounded' => $faker->boolean,
    ];
});
