<?php

/** @var Factory $factory */

use App\Category;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => '',
        'slug' => $faker->unique()->slug,
        'description' => $faker->paragraph(3),
        'color' => $faker->unique()->safeColorName,
    ];
});
