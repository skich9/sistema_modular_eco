<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
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
        // Compartir datos del usuario autenticado con todas las vistas
        View::composer('*', function ($view) {
            $usuario = session('usuario_autenticado', []);
            $view->with('usuario', $usuario);
        });
    }
}
