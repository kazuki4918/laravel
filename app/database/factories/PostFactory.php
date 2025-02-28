<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomDigitNotNull(),
        'title' => $faker->word(),
        'content' => $faker->word(),
        'amount' => $faker->randomNumber(5),
        'del_flg' => $faker->numberBetween(0, 1),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
