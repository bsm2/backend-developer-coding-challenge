<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;


class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
            Route::middleware('api')
                ->prefix('api/')
                //->namespace($this->clientNamespace)
                ->group(base_path('routes/api.php'));
    }
}
