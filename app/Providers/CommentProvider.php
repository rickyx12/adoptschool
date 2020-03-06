<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CommentProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\Contracts\CommentInterface', function ($app) {
          return new \App\Library\Services\Comment();
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
