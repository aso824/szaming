<?php

namespace Tests\Unit\Models\User;

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
}
