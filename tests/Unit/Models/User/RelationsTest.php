<?php

namespace Tests\Unit\Models\User;

use App\Models\Shopping;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RelationsTest extends TestCase
{
    use RefreshDatabase;

    public function testRelationshipWithShoppings()
    {
        $user = factory(User::class)->create();
        $shoppings = factory(Shopping::class, 5)->create([
            'user_id' => $user->id
        ]);

        $this->assertEmpty($shoppings->diff($user->shoppings));
        $this->assertCount(5, $user->shoppings);
    }
}
