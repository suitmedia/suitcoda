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

$factory->define(Suitcoda\Model\User::class, function ($faker) {
    return [
        'username' => $faker->userName,
        'email' => $faker->email,
        'password' => bcrypt($faker->word),
        'name' => $faker->name,
        'slug' => $faker->slug,
        'is_admin' => $faker->boolean,
        'is_active' => true,
        'last_login_at' => \Carbon\Carbon::now()
    ];
});
