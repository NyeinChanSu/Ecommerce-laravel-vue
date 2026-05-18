<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter; 
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();
        RateLimiter::for('api', function ($request) { return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip()); });
    }
}
