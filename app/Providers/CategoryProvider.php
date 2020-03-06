<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\Category;

class CategoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\Contracts\CategoryInterface', function ($app) {
          return new Category();
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
