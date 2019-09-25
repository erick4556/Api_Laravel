<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Categoria::class, function (Faker $faker) {
    return [
        "nombre"=>$faker->text(20),
    ];
});
