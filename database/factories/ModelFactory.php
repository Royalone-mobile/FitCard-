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

$factory->define(App\Model\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'credit'         => 5,
        'registerdate'   => $faker->date('Y-m-d', 'now'),
        'memberdate'     => $faker->date('Y-m-d', 'now'),
        'city'           => $faker->city,
        'phone'          => $faker->phoneNumber,
        'address'        => $faker->address,
        'zip'            => $faker->randomNumber(5)
    ];
});

$factory->define(App\Model\Plan::class, function (Faker\Generator $faker) {
    return [
        'plan'   => $faker->colorName,
        'price'  => $faker->randomNumber(2),
        'credit' => $faker->randomNumber(2)
    ];
});
