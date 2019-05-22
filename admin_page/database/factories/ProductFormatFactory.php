<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\ProductFormat;
use Faker\Generator as Faker;
use App\Product;

$factory->define(ProductFormat::class, function (Faker $faker) {
    return [
        'product_id' => function () {
            $product = Product::compounded()->inRandomOrder()->first();
            if ($product === null) {
                return factory(Product::class)->create(['is_compounded' => true])->id;
            } else {
                return $product->id;
            }
        },
        'name' => $faker->name,
        'added_price' => $faker->numberBetween(0, 500),
        'capacity' => $faker->numberBetween(0, 100),
        'minimum_quantity' => $faker->numberBetween(10, 100),
    ];
});
