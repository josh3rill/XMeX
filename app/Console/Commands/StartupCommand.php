<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class StartupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:startup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run startup commands';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->info('Running database migrations and seeders...');
            Artisan::call('migrate', ['--seed' => true]);
            $this->info(Artisan::output());

            $this->info('Seeding StockSymbols...');
            Artisan::call('db:seed', ['--class' => 'StockSymbolsSeeder']);
            $this->info(Artisan::output());

            $this->info('Startup commands executed successfully.');
        } catch (\Exception $e) {
            Log::error('Error running startup commands: ' . $e->getMessage());
            $this->error('Error running startup commands. Check logs for details.');
            return 1;
        }

        return 0;
    }
}