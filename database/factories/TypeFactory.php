<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MType;
use Faker\Generator as Faker;

$factory->define(MType::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'price' => 1000000,
        'description' => $faker->text,
        'created_at' => now()
    ];
});
