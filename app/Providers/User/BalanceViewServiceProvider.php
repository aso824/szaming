<?php

namespace App\Providers\User;

use App\Services\User\BalanceService;
use App\Services\Contracts\User\BalanceService as BalanceServiceInterface;
use App\ViewComposers\User\BalanceViewComposer;
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
        $this->bindContainer();

        View::composer('layouts.parts.user-balance', BalanceViewComposer::class);
    }

    /**
     * Bind BalanceService in case of ViewComposer.
     *
     * @return void
     */
    protected function bindContainer(): void
    {
        $this->app->when(BalanceViewComposer::class)
            ->needs(BalanceServiceInterface::class)
            ->give(function () {
                return app(BalanceService::class, [
                    'user' => auth()->user(),
                ]);
            });
    }
}
