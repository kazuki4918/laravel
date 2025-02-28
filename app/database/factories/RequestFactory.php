<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Request;
use Faker\Generator as Faker;

$factory->define(Request::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomDigitNotNull(),
        'post_id' => $faker->randomDigitNotNull(),
        'content' => $faker->realText(50),
        'tel' => $faker->phoneNumber(),
        'email' => $faker->email(),
        'deadline' => $faker->date('Y_m_d'),
        'status' => $faker->numberBetween(0, 1, 2),
        'del_flg' => $faker->numberBetween(0, 1),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
