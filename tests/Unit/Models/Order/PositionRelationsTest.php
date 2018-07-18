<?php

namespace Tests\Unit\Models\Order;

use App\Models\Order;
use App\Models\OrderPosition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PositionRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function testRelationshipWithOrder(): void
    {
        $order = factory(Order::class)->create();
        $position = factory(OrderPosition::class)->create([
            'order_id' => $order->id,
        ]);

        $this->assertEquals($order->id, $position->order->id);
    }

    public function testRelationshipWithUsers(): void
    {
        /** @var \App\Models\OrderPosition $position */
        $position = factory(OrderPosition::class)->create();
        [$user1, $user2] = factory(User::class, 2)->create();

        $position->users()->attach($user1);
        $position->users()->attach($user2);

        $this->assertEquals([
            $user1->id,
            $user2->id,
        ], $position->users->pluck('id')->toArray());
    }
}
