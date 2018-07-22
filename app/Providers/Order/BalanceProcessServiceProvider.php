<?php

namespace App\Providers\Order;

use Illuminate\Support\ServiceProvider;

class BalanceProcessServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->bindContainer();
    }

    /**
     * Bind OrderProcessService for whole application.
     *
     * @return void
     */
    protected function bindContainer(): void
    {
        $this->app->bind(
            \App\Services\Contracts\Order\OrderProcessService::class,
            \App\Services\Order\OrderProcessService::class
        );
    }
}
