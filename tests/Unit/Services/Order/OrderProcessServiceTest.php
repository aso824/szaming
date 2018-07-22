<?php

namespace Tests\Unit\Services\Order;

use App\Models\Order;
use App\Models\OrderPosition;
use App\Models\User;
use App\Services\Contracts\Order\OrderProcessService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderProcessServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testIfDebtsWasSetCorrectly(): void
    {
        $users = factory(User::class, 5)->create()->all();

        // Make array key equals to expected ID
        array_unshift($users, null);

        $order = factory(Order::class)->create([
            'user_id' => $users[1]->id,
        ]);

        // Sum for each order is 20 (10 * 2)
        $orderPositions = factory(OrderPosition::class, 3)->create([
            'order_id' => $order->id,
            'price'    => 10,
            'quantity' => 2,
        ])->all();

        // Make array key equals to expected ID
        array_unshift($orderPositions, null);

        // Owner will have debt for user 3 and 4
        $users[1]->setDebtFor($users[3], 7);
        $users[1]->setDebtFor($users[4], 10);

        // 20 per user
        $orderPositions[1]->users()->attach($users[2]);

        // 10 per user
        $orderPositions[2]->users()->attach($users[2]);
        $orderPositions[2]->users()->attach($users[3]);

        // 6.6667 per user
        $orderPositions[3]->users()->attach($users[2]);
        $orderPositions[3]->users()->attach($users[3]);
        $orderPositions[3]->users()->attach($users[4]);

        $service = app(OrderProcessService::class);
        $service->processOrder($order);

        $result = [];
        foreach ($users as $user) {
            if (!$user) {
                continue;
            }

            $result[$user->id] = $user->debts()->sum();
        }

        $this->assertEquals([
            1 => 3.3333,         // 6.6667 - 10, debt for user#4
            2 => 36.6667,        // 20 + 10 + 6.6667
            3 => 9.6667,         // (-7) + 10 + 6.6667
            4 => 0,              // 6.6667 - 10, receivable from user#1
            5 => 0,              // without any debts and receivables
        ], $result);
    }
}
