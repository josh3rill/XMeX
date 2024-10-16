<?php

namespace App\Jobs;

use App\Models\Stock;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UpdateCacheFromDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $symbol;

    public function __construct($symbol)
    {
        $this->symbol = $symbol;
    }

    public function handle()
    {
        try {
            // Fetch the latest stock data from the database
            $latestStock = Stock::where('symbol', $this->symbol)->orderBy('timestamp', 'desc')->first();

            if ($latestStock) {
                // Store the fetched data in the cache
                Cache::put("stock:{$this->symbol}", $latestStock->toArray(), 60); // Cache for 60 seconds
                Log::info("Updated cache for symbol: {$this->symbol}", ['data' => $latestStock->toArray()]); // Debugging statement
            } else {
                Log::warning("No data found for symbol: {$this->symbol}"); // Debugging statement
            }
        } catch (\Exception $e) {
            Log::error("Failed to update cache for symbol: {$this->symbol}. Error: ".$e->getMessage());
        }
    }
}
