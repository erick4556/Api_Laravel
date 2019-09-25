<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Profesor::class, function (Faker $faker) {
    return [
        "nombre"=>$faker->name,
        "email"=>$faker->unique()->safeEmail,
        "foto"=>$faker->imageUrl(100,100),
    ];
});
