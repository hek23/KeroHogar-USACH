<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Price;
use Faker\Generator as Faker;
use App\Product;

$factory->define(Price::class, function (Faker $faker) {
    return [
        'product_id' => function () {
            $product = Product::inRandomOrder()->first();
            if ($product === null) {
                return factory(Product::class)->create()->id;
            } else {
                return $product->id;
            }
        },
        'price' => $faker->numberBetween(500, 8000),
        'wholesaler' => $faker->boolean(),
    ];
});
