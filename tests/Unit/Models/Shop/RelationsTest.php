<?php

namespace Tests\Unit\Models\Shop;

use App\Models\Shop;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RelationsTest extends TestCase
{
    use RefreshDatabase;

    public function testRelationshipWithOrders()
    {
        $shop = factory(Shop::class)->create();
        $orders = factory(Order::class, 5)->create([
            'shop_id' => $shop->id
        ]);

        $this->assertEmpty($orders->diff($shop->orders));
        $this->assertCount(5, $shop->orders);
    }
}
