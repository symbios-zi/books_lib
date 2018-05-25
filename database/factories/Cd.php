<?php

use Faker\Generator as Faker;

$factory->define(App\Cd::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\Lorem($faker));

    return [
        'title' => $faker->text(20),
        'year' => $faker->year,
        'cover' => $faker->imageUrl($width = 640, $height = 480),
        'created_at' => $faker->dateTime()
    ];
});
