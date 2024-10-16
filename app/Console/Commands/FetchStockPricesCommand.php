<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\FetchStockPrice;
use Illuminate\Support\Facades\Log;

class FetchStockPricesCommand extends Command
{
    protected $signature = 'stocks:fetch';
    protected $description = 'Fetch stock prices for predefined symbols and store in database';
   
    // TODO: Implement the logic to FETCH $stockSymbols from database
    protected $stockSymbols = ["AAPL", "GOOGL", "GOOG", "MSFT", "AMZN", "TSLA", "NVDA", "META", "JPM", "V"];

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            foreach ($this->stockSymbols as $symbol) {
                FetchStockPrice::dispatch($symbol);
            }

            $this->info('Stock prices fetching jobs dispatched successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to dispatch stock price fetching jobs: ' . $e->getMessage());
            $this->error('Failed to dispatch stock price fetching jobs. Check logs for details.');
        }
    }
}