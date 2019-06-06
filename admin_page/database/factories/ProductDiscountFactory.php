<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\ProductDiscount;
use Faker\Generator as Faker;
use App\Product;

$factory->define(ProductDiscount::class, function (Faker $faker) {
    return [
        'product_id' => function () {
            $product = Product::inRandomOrder()->first();
            if ($product === null) {
                return factory(Product::class)->create()->id;
            } else {
                return $product->id;
            }
        },
        'discount_per_liter' => $faker->numberBetween(10, 50),
        'min_quantity' => $min = $faker->numberBetween(100, 500),
        'max_quantity' => $faker->numberBetween($min, 800),
    ];
});
