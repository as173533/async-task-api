<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // 👇 Register the API routes manually
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));

        // 👇 Register the Web routes (normal routes)
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
