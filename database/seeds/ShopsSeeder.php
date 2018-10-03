<?php

use App\Models\Shop;
use Illuminate\Database\Seeder;

class ShopsSeeder extends Seeder
{
    public function run(): void
    {
        factory(Shop::class, 20)->create();
    }
}
