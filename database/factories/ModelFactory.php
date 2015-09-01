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

$factory->define(Suitcoda\Model\Group::class, function ($faker) {
    return [
        'name' => $faker->word,
        'slug' => $faker->slug
    ];
});

$factory->define(Suitcoda\Model\User::class, function ($faker) {
    return [
        'username' => $faker->username,
        'email' => $faker->email,
        'password' => bcrypt(str_random(5)),
    ];
});
