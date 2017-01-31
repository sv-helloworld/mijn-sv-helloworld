<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('datetime', function ($expression) {
            return "<?php echo Carbon\Carbon::parse($expression)->format('d-m-Y H:i'); ?>";
        });

        Blade::directive('date', function ($expression) {
            return "<?php echo Carbon\Carbon::parse($expression)->format('d-m-Y'); ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
