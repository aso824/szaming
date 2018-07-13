<?php

namespace Tests\Unit\Models\Order;

use App\Models\Order;
use App\Models\OrderPosition;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function testRelationshipWithShop()
    {
        $shop = factory(Shop::class)->create();
        $order = factory(Order::class)->create([
            'shop_id' => $shop->id,
        ]);

        $this->assertEquals($shop->id, $order->shop->id);
    }

    public function testRelationshipWithUser()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertEquals($user->id, $order->user->id);
    }

    public function testRelationshipWithPositions()
    {
        $order = factory(Order::class)->create();
        $positions = factory(OrderPosition::class, 5)->create([
            'order_id' => $order->id,
        ]);

        $this->assertEmpty($positions->diff($order->orderPositions));
        $this->assertCount(5, $order->orderPositions);
    }
}
