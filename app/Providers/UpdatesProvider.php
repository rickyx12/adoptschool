<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UpdatesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\Contracts\UpdatesInterface', function ($app) {
          return new \App\Library\Services\Updates();     
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
