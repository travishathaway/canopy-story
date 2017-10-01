<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'token' => str_random(10)
    ];
});

$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    return [
        'tree_location' => $faker->name,
        'tree_id' => $faker->randomNumber,
        'content' => $faker->text,
        'language' => $faker->randomNumber % 2 == 0 ? 'en' : 'es'
    ];
});
