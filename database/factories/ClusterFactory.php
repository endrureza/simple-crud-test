<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MCluster;
use Faker\Generator as Faker;

$factory->define(MCluster::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->text,
        'created_at' => now()
    ];
});
