<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Movie;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Movie::class, function (Faker $faker) {
    return [
        'title' => $faker->realText($maxNbChars = 50, $indexSize = 1),
        'release_year' => $faker->year($max = 'now'),
        'description' => $faker->realText($maxNbChars = 200, $indexSize = 2)
    ];
});
