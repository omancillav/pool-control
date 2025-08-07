<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerificaRol;
use App\Http\Middleware\CheckInactivity;

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

        Gate::define('admin', function ($user) {
            return $user->rol === 'Administrador';
        });
        Gate::define('cliente', function ($user) {
            return $user->rol === 'Cliente';
        });
        Gate::define('profesor', function ($user) {
            return $user->rol === 'Profesor';
        });

        Route::aliasMiddleware('rol', VerificaRol::class);
        Route::aliasMiddleware('inactivity', CheckInactivity::class);
    }
}
