<?php

use Faker\Generator as Faker;

$factory->define(App\Models\OrderPosition::class, function (Faker $faker) {
    return [
        'order_id' => function () use ($faker) {
            if (\App\Models\Order::count() && $faker->boolean()) {
                return \App\Models\Order::inRandomOrder()->first()->id;
            }

            return factory(\App\Models\Order::class)->create()->id;
        },
        'name'     => $faker->sentence(3),
        'price'    => $faker->randomFloat(2, 1, 25),
        'quantity' => random_int(1, 3),
    ];
});
