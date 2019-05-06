<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Client;
use \Freshwork\ChileanBundle\Rut;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    $random_number = $faker->numberBetween(1000000, 25000000);
    $rut = new Rut($random_number);

    return [
        'rut' => $rut->fix()->normalize(),
    ];
});
