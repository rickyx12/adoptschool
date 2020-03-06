<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ProjectsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\Contracts\ProjectsInterface', function ($app) {
          return new \App\Library\Services\Projects();
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
