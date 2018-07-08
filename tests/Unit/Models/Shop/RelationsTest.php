<?php

namespace Tests\Unit\Models\Shop;

use App\Models\Shop;
use App\Models\Shopping;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RelationsTest extends TestCase
{
    use RefreshDatabase;

    public function testRelationshipWithShoppings()
    {
        $shop = factory(Shop::class)->create();
        $shoppings = factory(Shopping::class, 5)->create([
            'shop_id' => $shop->id
        ]);

        $this->assertEmpty($shoppings->diff($shop->shoppings));
        $this->assertCount(5, $shop->shoppings);
    }
}
