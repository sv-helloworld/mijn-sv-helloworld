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
        'email' => str_random(10).'@hz.nl',
        'address' => ucwords($faker->word).' '.rand(1, 999),
        'zip_code' => '4321 AB',
        'city' => $faker->city,
        'password' => bcrypt(str_random(10)),
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

$factory->defineAs(App\User::class, 'member', function (Faker\Generator $faker) use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, [
        'user_category_alias' => 'lid',
        'contribution_category_alias' => 'lid',
    ]);
});

$factory->define(App\Period::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'slug' => str_slug($faker->word),
        'start_date' => $faker->dateTimeBetween('now', '+1 week'),
        'end_date' => $faker->dateTimeBetween('+6 months', '+1 year'),
    ];
});

$factory->define(App\Contribution::class, function (Faker\Generator $faker) {
    return [
        'amount' => $faker->randomFloat(2, 18, 20),
        'available_from' => $faker->dateTimeBetween('-1 week', 'now'),
        'available_to' => $faker->dateTimeBetween('now', '+1 year'),
        'contribution_category_alias' => function () {
            return factory(App\User::class, 'member')->create()->contribution_category_alias;
        },
        'period_id' => function () {
            return factory(App\Period::class)->create()->id;
        },
    ];
});

$factory->defineAs(App\Contribution::class, 'early_bird', function (Faker\Generator $faker) use ($factory) {
    $contribution = $factory->raw(App\Contribution::class);

    return array_merge($contribution, [
        'amount' => $faker->randomFloat(2, 10, 15),
        'is_early_bird' => true,
    ]);
});

$factory->define(App\Subscription::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class, 'member')->create()->id;
        },
        'contribution_id' => function () {
            return factory(App\Contribution::class)->create()->id;
        },
    ];
});

$factory->defineAs(App\Subscription::class, 'early_bird', function (Faker\Generator $faker) use ($factory) {
    $subscription = $factory->raw(App\Subscription::class);

    return array_merge($subscription, [
        'contribution_id' => function () {
            return factory(App\Contribution::class, 'early_bird')->create()->id;
        },
    ]);
});

$factory->define(App\Activity::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
        'description' => $faker->sentence(10),
        'available_from' => $faker->dateTimeBetween('-1 week', 'now'),
        'available_to' => $faker->dateTimeBetween('+1 weeks', '+2 weeks'),
        'starts_at' => $faker->dateTimeBetween('+3 weeks', '+4 weeks'),
        'ends_at' => $faker->dateTimeBetween('+5 weeks', '+6 weeks'),
    ];
});

$factory->define(App\ActivityPrice::class, function (Faker\Generator $faker) {
    return [
        'activity_id' => function () {
            return factory(App\Activity::class)->create()->id;
        },
        'user_category_alias' => 'lid',
        'amount' => $faker->randomFloat(2, 1, 5),
    ];
});

$factory->define(App\ActivityEntry::class, function (Faker\Generator $faker) {
    $activity_price = factory(App\ActivityPrice::class)->create();

    return [
        'user_id' => function () {
            return factory(App\User::class, 'member')->create()->id;
        },
        'activity_id' => $activity_price->activity->id,
        'activity_price_id' => $activity_price->id,
    ];
});
