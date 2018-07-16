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
        View::composer('layouts.parts.user-balance', function($view) {
            $balanceService = app(\App\Services\User\BalanceService::class);
            $balance = $balanceService->getBalance();
            $formattedBalance = number_format($balance, 2);

            $view->with('balance', $formattedBalance)
                 ->with('currency', config('app.currency'));
        });
    }
}
