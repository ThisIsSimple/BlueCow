<?php

use Faker\Generator as Faker;

$factory->define(App\Trashcan::class, function (Faker $faker) {
    return [
        'trashcan_id' => 1,
        'in' => $faker->numberBetween(0, 20),
        'humidity' => $faker->numberBetween(20, 50),
        'ultrawave' => $faker->numberBetween(5, 100),
        'weight' => $faker->numberBetween(0, 30),
    ];
});
