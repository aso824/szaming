<?php

namespace App\Providers\User;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class BalanceViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        View::composer('layouts.parts.user-balance', function ($view) {
            $balanceService = app(\App\Services\User\BalanceService::class, [
                'user' => auth()->user(),
            ]);

            $balance = $balanceService->getBalance();

            /** @var \App\Services\Price\PriceFormatter $formatter */
            $formatter = app(\App\Services\Price\PriceFormatter::class);
            $formattedBalance = $formatter->formatPrice($balance);

            $view->with('balance', $formattedBalance);
        });
    }
}
