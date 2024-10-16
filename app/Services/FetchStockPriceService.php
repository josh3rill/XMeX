<?php

namespace App\Services;

use App\Models\Stock;
use Illuminate\Support\Facades\Log;

class FetchStockPriceService
{
    protected $stockSymbols = ['AAPL', 'GOOGL', 'GOOG', 'MSFT', 'AMZN', 'TSLA', 'NVDA', 'META', 'JPM', 'V'];

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
            Log::error('Failed to fetch stock prices: '.$e->getMessage());
        }
    }

    public function fetchStockPrice($symbol)
    {
        try {
            // Fetch the latest stock data from the database
            $latestStock = Stock::where('symbol', $symbol)
                                ->orderBy('timestamp', 'desc')
                                ->first();

            // Extract the close price to use as the previous close
            $previousClose = $latestStock ? $latestStock->close : null;

            Log::info("Latest stock data for symbol: {$symbol}", ['latestStock' => $latestStock]);

            // Fetch new stock data from the API
            $data = $this->alphaVantageService->getStockPrice($symbol);

            if ($data !== null) {
                // Update the data with the previous close value
                $data['previous_close'] = $previousClose;

                Log::info("New stock data for symbol: {$symbol}", ['data' => $data]);

                // Ensure the timestamp is unique and update the database
                Stock::updateOrCreate(
                    ['symbol' => $symbol, 'timestamp' => $data['timestamp']],
                    $data
                );

                Log::info("Fetched stock price for symbol: {$symbol}", ['data' => $data]); // Debugging statement
            } else {
                Log::warning("No data returned for symbol: {$symbol}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to fetch stock price for symbol: {$symbol}. Error: ".$e->getMessage());
        }
    }
}