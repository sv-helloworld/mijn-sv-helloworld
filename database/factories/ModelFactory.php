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
        'email' => strtolower($faker->firstName).'@hz.nl',
        'address' => ucwords($faker->word).' '.rand(1, 999),
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

/*$factory->defineAs(App\User::class, 'member', function (Faker\Generator $faker) use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, [
        'user_category_alias' => 'lid',
    ]);
});

$factory->define(App\Period::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'slug' => str_slug($faker->word),
        'start_date' => $faker->dateTimeThisYear(),
        'end_date' => $faker->dateTimeBetween('now', '+1 year'),
    ];
});

$factory->define(App\Contribution::class, function (Faker\Generator $faker) use ($factory) {
    $member = factory(App\User::class, 'member')->create();
    $period = $factory->raw(App\Period::class);

    return [
        'amount' => $faker->randomFloat(2, 15, 20),
        'early_bird_amount' => $faker->randomFloat(2, 10, 15),
        'early_bird_end_date' => $faker->dateTimeBetween('now', '+1 day'),
        'user_category_alias' => $member->user_category_alias,
        'period_id' => $period->id,
    ];
});

$factory->define(App\Subscription::class, function (Faker\Generator $faker) use ($factory) {
    $member = factory(App\User::class, 'member')->create();
    $contribution = factory(App\Contribution::class)->create();

    return [
        'user_id' => $member->id,
        'contribution_id' => $contribution->id,
    ];
});*/
