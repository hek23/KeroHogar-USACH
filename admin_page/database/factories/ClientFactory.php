<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Client;
use \Freshwork\ChileanBundle\Rut;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(Client::class, function (Faker $faker) {
    $random_number = $faker->numberBetween(1000000, 20000000);
    $rut = new Rut($random_number);

    return [
        'rut' => $rut->fix()->normalize(),
        'name' => $faker->name,
        'password' => Hash::make('password'),
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'wholesaler' => $faker->boolean(),
    ];
});
