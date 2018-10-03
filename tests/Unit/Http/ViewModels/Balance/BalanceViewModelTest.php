<?php

namespace Tests\Unit\Http\ViewModels\Balance;

use App\Http\ViewModels\Balance\BalanceViewModel;
use App\Models\User;
use App\Services\Price\PriceFormatter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BalanceViewModelTest extends TestCase
{
    use RefreshDatabase;

    /** @var BalanceViewModel */
    protected $viewModel;

    /** @var \App\Models\User */
    protected $user;

    protected function createUser(): User
    {
        return factory(User::class)->create();
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs($this->user = $this->createUser());

        $this->viewModel = app(BalanceViewModel::class);
    }

    public function testGetUser(): void
    {
        $this->assertSame($this->user->toArray(), $this->viewModel->getUser()->toArray());
    }

    public function testFormatPrice(): void
    {
        $formatter = app(PriceFormatter::class);

        $price = 55.55;

        $this->assertSame($formatter->formatPrice($price), $this->viewModel->formatPrice($price));
    }

    public function testDebtors(): void
    {
        $this->user->debtors()->save($this->createUser(), [
            'amount' => 44.05
        ]);

        $this->user->debtors()->save($this->createUser(), [
            'amount' => 44.06
        ]);

        $this->assertCount(2, $this->viewModel->getDebts());

        $this->assertEquals(44.06, $this->viewModel->getDebts()->first()->pivot->amount);
        $this->assertEquals(44.05, $this->viewModel->getDebts()->last()->pivot->amount);
    }

    public function testCreditors(): void
    {
        $this->user->creditors()->save($this->createUser(), [
            'amount' => 44.05
        ]);

        $this->user->creditors()->save($this->createUser(), [
            'amount' => 44.06
        ]);

        $this->assertCount(2, $this->viewModel->getCredits());

        $this->assertEquals(44.06, $this->viewModel->getCredits()->first()->pivot->amount);
        $this->assertEquals(44.05, $this->viewModel->getCredits()->last()->pivot->amount);
    }
}
