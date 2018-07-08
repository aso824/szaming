<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Shopping::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\Models\User::class)->create()->id,
        'shop_id' => factory(\App\Models\Shop::class)->create()->id,
        'purchased_at' => $faker->date()
    ];
});
