<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SchoolYearProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\Contracts\SchoolYearInterface', function ($app) {
          return new \App\Library\Services\SchoolYear();
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
