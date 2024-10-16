<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\StockRepositoryInterface;
use App\Repositories\StockRepository;
use Illuminate\Filesystem\Filesystem;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(StockRepositoryInterface::class, StockRepository::class);

        $this->app->bind('files', function ($app) {
            return new Filesystem();
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    
}
