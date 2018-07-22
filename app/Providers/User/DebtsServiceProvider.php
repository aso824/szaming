<?php

namespace App\Providers\User;

use Illuminate\Support\ServiceProvider;

class DebtsServiceProvider extends ServiceProvider
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
     * Bind DebtsService for whole application.
     *
     * @return void
     */
    protected function bindContainer(): void
    {
        $this->app->bind(
            \App\Services\Contracts\User\DebtsService::class,
            \App\Services\User\DebtsService::class
        );
    }
}
