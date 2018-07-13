<?php

namespace Tests\Unit\Models\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DebtsTest extends TestCase
{
    use RefreshDatabase;

    public function testCreditorsRelation(): void
    {
        [$user1, $user2] = factory(User::class, 2)->create();

        $user1->creditors()->attach($user2, ['amount' => 123.45]);

        $this->assertEquals($user2->id, $user1->creditors()->first()->id);
        $this->assertEquals(123.45, $user1->creditors->first()->pivot->amount);
    }

    public function testDebtorsRelation(): void
    {
        [$user1, $user2] = factory(User::class, 2)->create();

        $user1->debtors()->attach($user2, ['amount' => 123.45]);

        $this->assertEquals($user2->id, $user1->debtors()->first()->id);
        $this->assertEquals(123.45, $user1->debtors->first()->pivot->amount);
    }

    public function testDebtsGetter(): void
    {
        [$user1, $user2, $user3] = factory(User::class, 3)->create();

        $user1->creditors()->attach($user2, ['amount' => 123.45]);
        $user1->creditors()->attach($user3, ['amount' => 543.21]);

        $result = $user1->debts()->toArray();

        $this->assertEquals([
            $user2->id => 123.45,
            $user3->id => 543.21,
        ], $result);
    }

    public function testDebtsGetterWithZeroAmount(): void
    {
        [$user1, $user2] = factory(User::class, 2)->create();

        $user1->creditors()->attach($user2, ['amount' => 0]);

        $this->assertEmpty($user1->debts());
    }

    public function testReceivablesGetter(): void
    {
        [$user1, $user2, $user3] = factory(User::class, 3)->create();

        $user1->debtors()->attach($user2, ['amount' => 123.45]);
        $user1->debtors()->attach($user3, ['amount' => 543.21]);

        $result = $user1->receivables()->toArray();

        $this->assertEquals([
            $user2->id => 123.45,
            $user3->id => 543.21,
        ], $result);
    }

    public function testReceivablesGetterWithZeroAmount(): void
    {
        [$user1, $user2] = factory(User::class, 2)->create();

        $user1->debtors()->attach($user2, ['amount' => 0]);

        $this->assertEmpty($user1->receivables());
    }
}
