<?php

namespace Tests\Unit\Models\Shopping;

use App\Models\Shopping;
use App\Models\ShoppingPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PositionRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function testRelationshipWithShopping()
    {
        $shopping = factory(Shopping::class)->create();
        $position = factory(ShoppingPosition::class)->create([
            'shopping_id' => $shopping->id
        ]);

        $this->assertEquals($shopping->id, $position->shopping->id);
    }
}
