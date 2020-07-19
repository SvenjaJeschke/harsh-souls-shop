<?php

/** @var Factory $factory */

use App\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'display_name' => $faker->text(50),
        'description' => $faker->text(350),
        'price' => rand(5.00, 159.99),
        'is_active' => true
    ];
});
