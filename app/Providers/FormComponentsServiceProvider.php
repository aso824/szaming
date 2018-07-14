<?php

namespace App\Providers;

use Collective\Html\FormFacade as Form;
use Illuminate\Support\ServiceProvider;

class FormComponentsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        Form::component('bsText', 'components.form.text', ['name', 'value' => null, 'label' => null, 'attributes' => []]);
        Form::component('bsSubmit', 'components.form.submit', ['value' => null, 'attributes' => []]);
    }
}
