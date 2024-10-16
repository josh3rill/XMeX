<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DemoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is a demo command to test scheduling in Laravel';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Output a simple message to the log or console
        \Log::info('Demo command executed at ' . now());

        // Also print to the console when run manually
        $this->info('Demo command ran successfully!');

        return 0;
    }
}
