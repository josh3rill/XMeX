<?php

namespace App\Services;

use App\Models\Stock;
use App\Services\AlphaVantageService;
use Illuminate\Support\Facades\Log;

class FetchStockPriceService
{
    protected $stockSymbols = ["AAPL", "GOOGL", "GOOG", "MSFT", "AMZN", "TSLA", "NVDA", "META", "JPM", "V"];
    protected $alphaVantageService;

    public function __construct(AlphaVantageService $alphaVantageService)
    {
        $this->alphaVantageService = $alphaVantageService;
    }

    public function fetchAllStockPrices()
    {
        try {
            foreach ($this->stockSymbols as $symbol) {
                $this->fetchStockPrice($symbol);
            }
            Log::info('Stock prices fetching completed successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to fetch stock prices: ' . $e->getMessage());
        }
    }

    public function fetchStockPrice($symbol)
    {
        try {
            $data = $this->alphaVantageService->getStockPrice($symbol);
            if ($data !== null) {
                // Store data in the database
                Stock::updateOrCreate(
                    ['symbol' => $symbol, 'timestamp' => $data['timestamp']],
                    $data
                );
                Log::info("Fetched stock price for symbol: {$symbol}", ['data' => $data]); // Debugging statement
            } else {
                Log::warning("No data returned for symbol: {$symbol}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to fetch stock price for symbol: {$symbol}. Error: " . $e->getMessage());
        }
    }
}