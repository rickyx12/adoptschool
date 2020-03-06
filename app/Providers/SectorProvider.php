<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SectorProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\Contracts\SectorInterface', function ($app) {
          return new \App\Library\Services\Sector();
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
