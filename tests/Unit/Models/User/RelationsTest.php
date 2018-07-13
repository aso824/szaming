<?php

namespace Tests\Unit\Models\User;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RelationsTest extends TestCase
{
    use RefreshDatabase;

    public function testRelationshipWithOrders()
    {
        $user = factory(User::class)->create();
        $orders = factory(Order::class, 5)->create([
            'user_id' => $user->id
        ]);

        $this->assertEmpty($orders->diff($user->orders));
        $this->assertCount(5, $user->orders);
    }
}
