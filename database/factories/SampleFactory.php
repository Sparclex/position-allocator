<?php

use App\Sample;
use Faker\Generator as Faker;

$factory->define(Sample::class, function (Faker $faker) {
    return [
        'id' => $faker->unique->randomNumber(7),
        'position' =>
    ];
});
