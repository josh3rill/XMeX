<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        StartupCommand::class,
        FetchStockPricesCommand::class,
        UpdateCacheCommand::class,

    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
            ->everyMinute()
            ->appendOutputTo(storage_path('logs/inspire.log'));

        $schedule->command('update:cache')
            ->everyMinute()
            ->appendOutputTo(storage_path('logs/update_cache.log'));

        $schedule->command('fetch:stockprice')
            ->dailyAt('00:00')
            ->appendOutputTo(storage_path('logs/fetch_stockprice.log'));
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
