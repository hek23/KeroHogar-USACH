<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\TimeBlock;
use Faker\Generator as Faker;

$factory->define(TimeBlock::class, function (Faker $faker) {
    $end = $faker->time();
    return [
        'max_orders' => $faker->numberBetween(10, 50),
        'start' => $faker->time($end),
        'end' => $end,
    ];
});
