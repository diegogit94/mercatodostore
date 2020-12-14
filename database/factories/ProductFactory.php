<?php

/** @var Factory $factory */

use App\Product;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->colorName,
        'description' => $faker->paragraph(3),
        'short_description' => $faker->paragraph(1),
        'image' => $faker->imageUrl(370, 403, 'abstract'),
        'price' => $faker->randomFloat(2, 1),
        'quantity' => 5,
        'visible' => 1,
//        'category_id' => rand(1, 2),
        'user_id' => 1,
    ];
});
