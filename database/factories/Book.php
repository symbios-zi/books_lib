<?php

use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\Lorem($faker));

    return [
        'name' => $faker->text(20),
        'isbn' => $faker->isbn13,
        'year' => $faker->year
    ];
});
