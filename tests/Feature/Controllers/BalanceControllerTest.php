<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BalanceControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs($this->user = factory(User::class)->create());
    }

    public function testPageStatus(): void
    {
        $this->get(route('balance.index'))->assertOk();
    }

    public function testDebtorsOnPage(): void
    {
        $users = factory(User::class, 5)->create();

        foreach ($users as $user) {
            $this->user->debtors()->save($user, [
                'amount' => 1,
            ]);
        }

        $response = $this->get(route('balance.index'));

        foreach ($users as $user) {
            $response->assertSee($user->name);
        }
    }

    public function testCreditorsOnPage(): void
    {
        $users = factory(User::class, 5)->create();

        foreach ($users as $user) {
            $this->user->creditors()->save($user, [
                'amount' => 1,
            ]);
        }

        $response = $this->get(route('balance.index'));

        foreach ($users as $user) {
            $response->assertSee($user->name);
        }
    }
}
