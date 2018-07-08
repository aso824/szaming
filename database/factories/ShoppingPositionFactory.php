<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ShoppingPosition::class, function (Faker $faker) {
    return [
        'shopping_id' => function() use ($faker) {
            if (\App\Models\Shopping::count() && $faker->boolean()) {
                return \App\Models\Shopping::inRandomOrder()->first()->id;
            }

            return factory(\App\Models\Shopping::class)->create()->id;
        },
        'name' => $faker->sentence(3),
        'price' => $faker->randomFloat(2, 1, 25),
        'quantity' => random_int(1, 3)
    ];
});
