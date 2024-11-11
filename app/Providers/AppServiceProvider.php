<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

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
        Passport::enablePasswordGrant();

        Passport::tokensCan([
            'create-post' => 'Crear un nuevo post', 
            'read-post' => 'Leer un post', 
            'update-post' => 'Actualizar un post', 
            'delete-post' => 'Eliminar un post'
        ]);

        Passport::setDefaultScope([
            'read-post',
        ]);
    }
}
