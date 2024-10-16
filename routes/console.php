<?php

use App\Console\Commands\FetchStockPricesCommand;
use App\Console\Commands\UpdateCacheCommand;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment('update:cache');
})->purpose('Display an inspiring quote')->everyMinute();

Artisan::command('update:cache', function () {
    $command = app(UpdateCacheCommand::class);
    $command->handle();
})->purpose('Update Cache From Database')->everyMinute();

Artisan::command('fetch:stockprice', function () {
    $command = app(FetchStockPricesCommand::class);
    $command->handle();
})->purpose('Fetch Stock Price')->days('1');
