<?php

namespace Tests\Feature;

use App\Services\Price\PriceFormatter;
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

        $response = $this->get(route('home'));

        $expectedResultFormatted = $this->getPriceFormatter()->formatPrice('-123');
        $response->assertSee($expectedResultFormatted);
    }

    protected function getPriceFormatter(): PriceFormatter
    {
        config()->set('settings.path', storage_path('settings_testing.json'));

        return app(PriceFormatter::class);
    }
}
