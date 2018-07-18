<?php

namespace Tests\Unit\Models\User;

use App\Models\Order;
use App\Models\OrderPosition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RelationsTest extends TestCase
{
    use RefreshDatabase;

    public function testRelationshipWithOrders(): void
    {
        $user = factory(User::class)->create();
        $orders = factory(Order::class, 5)->create([
            'user_id' => $user->id,
        ]);

        $this->assertEmpty($orders->diff($user->orders));
        $this->assertCount(5, $user->orders);
    }

    public function testRelationshipWithOrderPositions(): void
    {
        /** @var \App\Models\User $user */
        $user = factory(User::class)->create();
        [$position1, $position2] = factory(OrderPosition::class, 2)->create();

        $user->orderPositions()->attach($position1);
        $user->orderPositions()->attach($position2);

        $this->assertEquals([
            $position1->id,
            $position2->id,
        ], $user->orderPositions->pluck('id')->toArray());
    }
}
