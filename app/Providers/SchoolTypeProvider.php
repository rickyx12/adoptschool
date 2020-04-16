<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SchoolTypeProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\Contracts\SchoolTypeInterface', function ($app) {
          return new \App\Library\Services\SchoolType();
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
