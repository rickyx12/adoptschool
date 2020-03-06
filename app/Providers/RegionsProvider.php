<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\Regions;

class RegionsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\Contracts\RegionsInterface', function ($app) {
          return new Regions();
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
