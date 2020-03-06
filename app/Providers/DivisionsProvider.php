<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DivisionsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\Contracts\DivisionsInterface', function ($app) {
          return new \App\Library\Services\Divisions();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
