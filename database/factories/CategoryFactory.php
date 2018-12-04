<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Category::class, function (Faker $faker) {
    return [
        'name' => rtrim($faker->sentence(1), '.'),
    ];
});
