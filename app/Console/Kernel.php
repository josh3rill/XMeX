<?php
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        try {
            // Schedule the job to fetch data from the API and store it in the database daily
            $schedule->command('demo:run')->everyMinute()->timezone('Europe/Malta');

            if (isset($stockSymbols) && is_array($stockSymbols)) {
                foreach ($stockSymbols as $symbol) {
                    $schedule->command('stocks:fetch')->daily()->timezone('Europe/Malta');
                }

                // Schedule the job to update the cache from the database every minute
                foreach ($stockSymbols as $symbol) {
                    $schedule->command('cache:update')->everyMinute()->timezone('Europe/Malta');
                }
            } else {
                Log::error('Stock symbols are not defined or not an array.');
            }
        } catch (\Exception $e) {
            Log::error('Error scheduling commands: ' . $e->getMessage());
        }
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}