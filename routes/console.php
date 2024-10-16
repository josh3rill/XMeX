<?php
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\FetchStockPricesCommand;
use App\Console\Commands\UpdateCacheCommand;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->everyFourMinutes();

Artisan::command('update:cache', function () {
    $command = new UpdateCacheCommand();
    $command->handle();
})->purpose('Update Cache From Database')->everyMinute();

Artisan::command('fetch:stockprice', function () {
    $command = new FetchStockPricesCommand(app(App\Services\AlphaVantageService::class));
    $command->handle();
})->purpose('Fetch Stock Price')->days('2');                                                                                                                                                                                                                                                                                                                                 