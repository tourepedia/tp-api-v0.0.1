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

# users's factory
$factory->defineAs(App\Models\User::class, "super_admin", function ($faker) {
    return [
        'name' => env("APP_SU_NAME", "Super Admin"),
        'email' => env("APP_SU_EMAIL", "super.admin@tourepedia.com"),
        'password' => app('hash')->make(env("APP_SU_PASS", "secret")),
        'remember_token' => str_random(10),
    ];
});


// user roles factory
$factory->defineAs(App\Models\Tags\UserRole::class, "super_admin", function ($faker) {
    return [
        'name' => 'Super Admin',
        'description' => 'A user who holds all the permissions',
        "created_by" => 1
    ];
});
