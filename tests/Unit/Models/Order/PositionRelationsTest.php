<?php

namespace Tests\Unit\Models\Order;

use App\Models\Order;
use App\Models\OrderPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PositionRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function testRelationshipWithOrder()
    {
        $order = factory(Order::class)->create();
        $position = factory(OrderPosition::class)->create([
            'order_id' => $order->id
        ]);

        $this->assertEquals($order->id, $position->order->id);
    }
}
