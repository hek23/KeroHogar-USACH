<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Address;
use Faker\Generator as Faker;
use App\Client;
use App\Town;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'client_id' => Client::inRandomOrder()->first()->id,
        'town_id' => Town::inRandomOrder()->first()->id,
        'address' => $faker->streetAddress,
        'alias' => $faker->randomElement(['Hogar', 'Trabajo', 'Casa', 'Estudio', 'Industria', 'Negocio', 'Oficina']),
    ];
});
