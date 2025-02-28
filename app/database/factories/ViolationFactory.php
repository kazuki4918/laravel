<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Violation;
use Faker\Generator as Faker;

$factory->define(Violation::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomDigitNotNull(),
        'post_id' => $faker->randomDigitNotNull(),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
