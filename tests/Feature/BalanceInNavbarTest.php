<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BalanceInNavbarTest extends TestCase
{
    use RefreshDatabase;

    public function testBalanceInNavbar(): void
    {
        [$user1, $user2] = factory(\App\Models\User::class, 2)->create();
        $this->actingAs($user1);

        $user2->creditors()->attach([
            $user2->id => [
                'debtor_id' => $user1->id,
                'amount'    => 123,
            ],
        ]);

        $currency = config('app.currency');

        $response = $this->get(route('home'));

        $response->assertSee("-123.00 {$currency}");
    }
}
