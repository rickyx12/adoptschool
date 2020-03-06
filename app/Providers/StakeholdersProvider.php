<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class StakeholdersProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\Contracts\StakeholdersInterface', function ($app) {
          return new \App\Library\Services\Stakeholders();
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
