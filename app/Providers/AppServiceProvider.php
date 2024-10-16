<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\StockRepositoryInterface;
use App\Repositories\StockRepository;
use Illuminate\Filesystem\Filesystem;
use App\Services\AlphaVantageService;



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

        $this->app->singleton(AlphaVantageService::class, function ($app) {
            return new AlphaVantageService();
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
