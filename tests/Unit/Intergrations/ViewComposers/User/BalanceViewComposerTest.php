<?php

namespace Tests\Unit\Intergrations\ViewComposers\User;

use App\Services\Price\PriceFormatter;
use App\ViewComposers\User\BalanceViewComposer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class BalanceViewComposerTest extends TestCase
{
    use RefreshDatabase;

    public function testViewComposerBalanceVariable()
    {
        $user = factory(\App\Models\User::class)->create();

        $balanceService = new class($user) implements \App\Services\Contracts\User\BalanceService {
            public function __construct(\App\Models\User $user)
            {
            }

            public function getBalance(): float
            {
                return 22.22;
            }
        };

        $priceFormatter = app(PriceFormatter::class);

        $composer = new BalanceViewComposer($balanceService, $priceFormatter);

        $view = Mockery::spy(View::class);

        $composer->compose($view);

        $view->shouldHaveReceived('with')->with('balance', $priceFormatter->formatPrice(22.22));
    }
}