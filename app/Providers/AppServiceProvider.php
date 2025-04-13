<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Desabilita o Vite em desenvolvimento
        if (config('app.env') !== 'production') {
            Blade::directive('vite', function () {
                return '<!-- Vite Disabled in Development -->';
            });
            
            Blade::directive('vite_assets', function () {
                return '<!-- Vite Disabled in Development -->';
            });
        }
    }
}
