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
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Band::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'start_date' => $faker->date(),
        'website' => $faker->url,
        'still_active' => $faker->boolean
    ];
});


$factory->define(App\Album::class, function (Faker\Generator $faker) {
    return [
        'band_id' => $faker->numberBetween(1, 30),
        'name' => $faker->catchPhrase,
        'recorded_date' => $faker->date(),
        'release_date' => $faker->date(),
        'number_of_tracks' => $faker->numberBetween(1, 20),
        'label' => $faker->company,
        'producer' => $faker->name,
        'genre' => $faker->company
    ];
});