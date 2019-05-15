<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Persona;
use Faker\Generator as Faker;

$factory->define(Persona::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'correo' => $faker->email,
        'fechaNacimiento' => $faker->date()
    ];
});
