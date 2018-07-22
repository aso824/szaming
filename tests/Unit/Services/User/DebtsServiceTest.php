<?php

namespace Tests\Unit\Services\User;

use App\Models\User;
use App\Services\Contracts\User\DebtsService;
use App\Services\User\BalanceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DebtsServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Models\User */
    protected $user1;

    /** @var \App\Models\User */
    protected $user2;

    /** @var DebtsService */
    protected $debtsService;

    /** @var BalanceService */
    protected $balanceService;

    protected function setUp(): void
    {
        parent::setUp();

        [$this->user1, $this->user2] = factory(User::class, 2)->create();

        $this->debtsService = app(DebtsService::class);
        $this->balanceService = app(BalanceService::class, [
            'user' => $this->user1,
        ]);

        $this->debtsService->actingAs($this->user1);
    }

    public function testExceptionWithoutUser(): void
    {
        $freshService = app(DebtsService::class);

        $this->expectException(\InvalidArgumentException::class);

        $freshService->addDebt($this->user1, 10);
    }

    public function testAddingDebt(): void
    {
        $this->debtsService->addDebt($this->user2, 7);

        $this->assertEquals(-7.0, $this->balanceService->getBalance());
    }

    public function testAddingReceivable(): void
    {
        $this->debtsService->addReceivable($this->user2, 7);

        $this->assertEquals(7.0, $this->balanceService->getBalance());
    }

    public function testBothButBalancePositive(): void
    {
        $this->debtsService->addDebt($this->user2, 7);
        $this->debtsService->addReceivable($this->user2, 9);

        $this->assertEquals(2.0, $this->balanceService->getBalance());
    }

    public function testBothButBalanceNegative(): void
    {
        $this->debtsService->addDebt($this->user2, 7);
        $this->debtsService->addReceivable($this->user2, 4);

        $this->assertEquals(-3.0, $this->balanceService->getBalance());
    }

    public function testBothButInReverseOrder(): void
    {
        $this->debtsService->addReceivable($this->user2, 10);
        $this->debtsService->addDebt($this->user2, 4);

        $this->assertEquals(6.0, $this->balanceService->getBalance());
    }
}
