<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Gateway;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function boot()
    {
        Schema::defaultStringLength(191);

        //overwrite delete method for gateway model (on delete cascade)
        Gateway::deleted(function($gateway) {
            $gateway->nodos()->delete();
        });
        //on restored event for model gateway
        Gateway::restored(function($gateway) {
            $gateway->nodos()->withTrashed()->restore();
        });

    }


    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Wn\Generators\CommandsServiceProvider');
        }
    }
}
