<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\ProductFormat;
use Faker\Generator as Faker;
use App\Product;

$factory->define(ProductFormat::class, function (Faker $faker) {
    return [
        'product_id' => Product::compounded()->inRandomOrder()->first(),
        'name' => $faker->name,
        'added_price' => $faker->numberBetween(0, 500),
        'capacity' => $faker->numberBetween(0, 100),
        'minimum_quantity' => $faker->numberBetween(10, 100),
    ];
});
