<?php

namespace App\Services;

use App\Models\Stock;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UpdateCacheService
{
    protected $stockSymbols = ['AAPL', 'GOOGL', 'GOOG', 'MSFT', 'AMZN', 'TSLA', 'NVDA', 'META', 'JPM', 'V'];

    public function updateAllCaches()
    {
        try {
            foreach ($this->stockSymbols as $symbol) {
                $this->updateCache($symbol);
            }
            Log::info('Cache update completed successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update cache: ' . $e->getMessage());
        }
    }

    public function updateCache($symbol)
    {
        try {
            // Fetch the latest stock data from the database
            $latestStock = Stock::where('symbol', $symbol)->orderBy('timestamp', 'desc')->first();

            if ($latestStock) {
                // Store the fetched data in the cache
                Cache::put("stock:{$symbol}", $latestStock->toArray(), 60); // Cache for 60 seconds
                Log::info("Updated cache for symbol: {$symbol}", ['data' => $latestStock->toArray()]); // Debugging statement
            } else {
                Log::warning("No data found for symbol: {$symbol}"); // Debugging statement
            }
        } catch (\Exception $e) {
            Log::error("Failed to update cache for symbol: {$symbol}. Error: " . $e->getMessage());
        }
    }
}
