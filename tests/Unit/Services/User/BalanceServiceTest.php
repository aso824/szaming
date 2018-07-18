<?php

namespace Tests\Unit\Services\User;

use App\Services\Contracts\User\BalanceService as BalanceServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BalanceServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testBalanceServiceInstance(): void
    {
        $service = app(\App\Services\User\BalanceService::class);

        $this->assertInstanceOf(BalanceServiceInterface::class, $service);
    }

    public function testDebts(): void
    {
        [$user1, $user2] = factory(\App\Models\User::class, 2)->create();

        /** @var \App\Services\User\BalanceService $service */
        $service = app(\App\Services\User\BalanceService::class, [
            'user' => $user1,
        ]);

        $user2->creditors()->attach([
            $user2->id => [
                'debtor_id' => $user1->id,
                'amount'    => 123,
            ],
        ]);

        $this->assertEquals(-123, $service->getBalance());
    }

    public function testReceivables(): void
    {
        [$user1, $user2] = factory(\App\Models\User::class, 2)->create();

        /** @var \App\Services\User\BalanceService $service */
        $service = app(\App\Services\User\BalanceService::class, [
            'user' => $user1,
        ]);

        $user1->creditors()->attach([
            $user1->id => [
                'debtor_id' => $user2->id,
                'amount'    => 123,
            ],
        ]);

        $this->assertEquals(123, $service->getBalance());
    }

    public function testBalance(): void
    {
        [$user1, $user2] = factory(\App\Models\User::class, 2)->create();

        /** @var \App\Services\User\BalanceService $service */
        $service = app(\App\Services\User\BalanceService::class, [
            'user' => $user1,
        ]);

        $user2->creditors()->attach([
            $user2->id => [
                'debtor_id' => $user1->id,
                'amount'    => 123,
            ],
        ]);

        $user1->creditors()->attach([
            $user1->id => [
                'debtor_id' => $user2->id,
                'amount'    => 23,
            ],
        ]);

        $this->assertEquals(-100, $service->getBalance());
    }
}
