<?php

/** @var Factory $factory */

use App\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->domainWord,
        'slug' => $faker->slug,
        'description' => $faker->paragraph(3),
        'short_description' => $faker->paragraph(1),
        'image' => $faker->unique()->imageUrl(370, 403, 'abstract'),
        'price' => $faker->randomFloat(2, 1),
        'visible' => true,
    ];
});