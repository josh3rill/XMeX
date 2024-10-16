<?php

namespace App\Jobs;

use App\Models\Stock;
use App\Services\AlphaVantageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchStockPrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $symbol;

    public function __construct($symbol)
    {
        $this->symbol = $symbol;
    }

    public function handle(AlphaVantageService $alphaVantageService)
    {
        try {
            // Fetch the latest stock data from the database
            $latestStock = Stock::where('symbol', $this->symbol)
                                ->orderBy('timestamp', 'desc')
                                ->first();

            // Extract the close price to use as the previous close
            $previousClose = $latestStock ? $latestStock->close : null;

            // Fetch new stock data from the API
            $data = $alphaVantageService->getStockPrice($this->symbol);

            if ($data !== null) {
                // Update the data with the previous close value
                $data['previous_close'] = $previousClose;

                // Store data in the database
                Stock::updateOrCreate(
                    ['symbol' => $this->symbol, 'timestamp' => $data['timestamp']],
                    $data
                );

                Log::info("Fetched stock price for symbol: {$this->symbol}", ['data' => $data]);
            } else {
                Log::warning("No data returned for symbol: {$this->symbol}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to fetch stock price for symbol: {$this->symbol}. Error: " . $e->getMessage());
        }
    }
}