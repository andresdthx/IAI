<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Proyecto::class, function (Faker $faker) {
    return [
        'nombre' => $faker->catchPhrase,
        'descripcion' => $faker->bs,
        'user_id' => App\User::all()->random(1)[0]->id,
    ];
});

