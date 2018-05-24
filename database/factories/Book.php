<?php

use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\Lorem($faker));

    return [
        'title' => $faker->text(20),
        'isbn' => $faker->isbn13,
        'year' => $faker->year,
        'created_at' => $faker->dateTime()
    ];
});
