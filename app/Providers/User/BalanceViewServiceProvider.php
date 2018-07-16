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

            $view->with('balance', 0)
                 ->with('currency', config('app.currency'));
        });
    }
}
