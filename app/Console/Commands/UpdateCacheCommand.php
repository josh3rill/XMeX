<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UpdateCacheFromDatabase;
use Illuminate\Support\Facades\Log;

class UpdateCacheCommand extends Command
{
    protected $signature = 'cache:update';
    protected $description = 'Update cache from database for predefined symbols';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // TODO: Implement the logic to FETCH $stockSymbols from database
        $stockSymbols = ["AAPL", "GOOGL", "GOOG", "MSFT", "AMZN", "TSLA", "NVDA", "META", "JPM", "V"];
        
        try {
            foreach ($stockSymbols as $symbol) {
                UpdateCacheFromDatabase::dispatch($symbol);
                $this->info("Dispatched job for symbol: {$symbol}"); // Debugging statement
            }

            $this->info('Cache update jobs dispatched successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to dispatch cache update jobs: ' . $e->getMessage());
            $this->error('Failed to dispatch cache update jobs. Check logs for details.');
        }
    }
}