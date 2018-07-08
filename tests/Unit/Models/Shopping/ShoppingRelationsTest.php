<?php

namespace Tests\Unit\Models\Shopping;

use App\Models\Shop;
use App\Models\Shopping;
use App\Models\ShoppingPosition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShoppingRelationsTest extends TestCase
{
    use RefreshDatabase;

    function testRelationshipWithShop()
    {
        $shop = factory(Shop::class)->create();
        $shopping = factory(Shopping::class)->create([
            'shop_id' => $shop->id,
        ]);

        $this->assertEquals($shop->id, $shopping->shop->id);
    }

    function testRelationshipWithUser()
    {
        $user = factory(User::class)->create();
        $shopping = factory(Shopping::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertEquals($user->id, $shopping->user->id);
    }

    function testRelationshipWithPositions()
    {
        $shopping = factory(Shopping::class)->create();
        $positions = factory(ShoppingPosition::class, 5)->create([
            'shopping_id' => $shopping->id,
        ]);

        $this->assertEmpty($positions->diff($shopping->shoppingPositions));
        $this->assertCount(5, $shopping->shoppingPositions);
    }
}
