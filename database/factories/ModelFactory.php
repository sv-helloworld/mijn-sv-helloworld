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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => strtolower($faker->firstName) . '@hz.nl',
        'address' => ucwords($faker->word) . ' ' . rand(1, 999),
        'zip_code' => '4321 AB',
        'city' => $faker->city,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'activated' => true,
        'verified' => true,
    ];
});

$factory->defineAs(App\User::class, 'admin', function (Faker\Generator $faker) use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, [
        'account_type' => 'admin',
    ]);
});

/*$factory->defineAs(App\User::class, 'lid', function (Faker\Generator $faker) use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, [
        'user_category' => 'lid',
    ]);
});*/