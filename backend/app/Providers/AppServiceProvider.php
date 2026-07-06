<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;

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
        #Define o rate limit global
        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(60);
        });

        View::addNamespace('view', [
            resource_path('../../frontend/views'),
        ]);
    }
}
