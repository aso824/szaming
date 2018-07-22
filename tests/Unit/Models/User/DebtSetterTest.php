<?php

namespace Tests\Unit\Models\User;

use App\Exceptions\User\InvalidDebtAmountException;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DebtSetterTest extends TestCase
{
    use RefreshDatabase;

    public function testDebtsSetter(): void
    {
        [$user1, $user2] = factory(User::class, 2)->create();

        $user1->setDebtFor($user2, 10);

        $this->assertEquals([
            2 => 10,
        ], $user1->debts()->toArray());
    }

    /**
     * @depends testDebtsSetter
     */
    public function testDebtsRemover(): void
    {
        [$user1, $user2] = factory(User::class, 2)->create();

        $user1->setDebtFor($user2, 10);

        $user1->removeDebtFor($user2);

        $this->assertEmpty($user1->debts()->toArray());
    }

    /**
     * @depends testDebtsSetter
     */
    public function testSetDebtToNegative(): void
    {
        [$user1, $user2] = factory(User::class, 2)->create();

        $this->expectException(InvalidDebtAmountException::class);

        $user1->setDebtFor($user2, -10);
    }

    /**
     * @depends testDebtsSetter
     * @depends testDebtsRemover
     */
    public function testSetDebtToZero(): void
    {
        [$user1, $user2] = factory(User::class, 2)->create();

        $user1->setDebtFor($user2, 10);
        $user1->setDebtFor($user2, 0);

        $this->assertEmpty($user1->debts()->toArray());
    }
}
