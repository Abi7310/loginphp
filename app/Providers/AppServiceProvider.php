<?php

namespace App\Providers;
use Illuminate\Support\Facades\Route;


use Illuminate\Support\ServiceProvider;
// Assuming you've already moved the 'routes' block as discussed previously,
// you might not need 'use Illuminate\Support\Facades\Route;' here anymore.
// If you still have other code that uses Route, keep it.

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
    Route::middleware('api')
        ->prefix('api')
        ->group(base_path('routes/api.php'));

    Route::middleware('web')
        ->group(base_path('routes/web.php'));
}
}