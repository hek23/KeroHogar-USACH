<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->catchPhrase,
        'price' => $faker->numberBetween(100, 500),
        'wholesaler_price' => $faker->numberBetween(100, 500),
        'unit' => $faker->firstNameMale,
        'plural' => $faker->firstNameFemale,
        'liters_per_unit' => $faker->numberBetween(10, 100),
        'minimum_amount' => $faker->numberBetween(10, 100),
    ];
});
