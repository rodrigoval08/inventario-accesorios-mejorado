<?php

namespace App\Providers;

use App\Models\Producto;
use App\Observers\ProductoObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Registra movimientos automáticamente cuando cambia el stock de un producto
        Producto::observe(ProductoObserver::class);
    }
}