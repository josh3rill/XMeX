<?php

namespace App\Providers;

use App\Repositories\StockRepository;
use App\Repositories\StockRepositoryInterface;
use App\Services\AlphaVantageService;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

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
