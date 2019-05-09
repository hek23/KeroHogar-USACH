<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\TimeBlock;
use Faker\Generator as Faker;

$factory->define(TimeBlock::class, function (Faker $faker) {
    $end = $faker->time();
    return [
        'start' => $faker->time($end),
        'end' => $end,
    ];
});
