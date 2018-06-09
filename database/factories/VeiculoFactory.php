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

$factory->define(App\Veiculo::class, function (Faker $faker) {
    return [
        'veiculo' => $faker->word,
        'marca' => $faker->company,
        'ano' => $faker->year,
        'descricao' => $faker->text,
        'vendido' => $faker->boolean,
        'created' => $faker->dateTimeBetween('-60 days', '2018-05-31'),
        'updated' => $faker->dateTimeBetween('-5 days', 'now')
    ];
});
