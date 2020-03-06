<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SchoolProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\Contracts\SchoolInterface', function ($app) {
          return new \App\Library\Services\School();
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
