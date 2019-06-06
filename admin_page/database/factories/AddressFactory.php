<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Address;
use Faker\Generator as Faker;
use App\Client;
use App\Town;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'client_id' => function () {
            $client = Client::inRandomOrder()->first();
            if ($client === null) {
                return factory(Client::class)->create()->id;
            } else {
                return $client->id;
            }
        },
        'town_id' => function () {
            $town = Town::inRandomOrder()->first();
            if ($town === null) {
                return factory(Town::class)->create()->id;
            } else {
                return $town->id;
            }
        },
        'address' => $faker->streetAddress,
        'alias' => $faker->randomElement(['Hogar', 'Trabajo', 'Casa', 'Estudio', 'Industria', 'Negocio', 'Oficina']),
    ];
});
