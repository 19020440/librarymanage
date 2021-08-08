<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'category' => sprintf("%03d", $faker->numberBetween(0, 999)),
        'auth' => $faker->name(),
        'publisher' => $faker->address(),
        'translator' => $faker->name(),
        'country' => $faker->country(),
        'quantity' => $faker->numberBetween(10, 50),
        'price' => $faker->numberBetween(100000, 500000),
        'year_start' => $faker->numberBetween(1900, 2021),
        'created_by' => 1
    ];
});
