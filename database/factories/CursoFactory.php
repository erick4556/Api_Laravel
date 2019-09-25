<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Curso::class, function (Faker $faker) {
    return [
        "nombre"=>$faker->text(50),
        "descripcion"=>$faker->paragraphs(3,true),
        "icono"=>$faker->imageUrl(400,400),
        "portada"=>$faker->imageUrl(640,420),
        "video"=>$faker->url,
        "etiquetas"=>$faker->text(50),
        "profesor_id"=>function(){
            return factory(App\Models\Profesor::class)->create()->id;
        },
        "categoria_id"=>function(){
            return factory(App\Models\Categoria::class)->create()->id;
        },
    ];
});
