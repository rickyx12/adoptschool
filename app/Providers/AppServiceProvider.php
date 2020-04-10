<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::directive('money', function ($amount) {
            return "<?php echo '₱' .str_replace('.00','',number_format($amount,2)); ?>";
        });

        Blade::directive("formatDate", function ($date) {
            return "<?php echo date('M d, Y', strtotime($date)) ?>";
        });          
    }
}
