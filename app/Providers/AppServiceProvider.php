<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
    /**
     * @OA\Info(
     *     title="Título de tu API",
     *     version="1.0",
     *     description="Descripción breve de la API"
     * )
     */

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
        //
    }
}
