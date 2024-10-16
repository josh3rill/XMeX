<?php

namespace App\Services;

use App\Jobs\FetchStockPrice;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class StockService
{
    public function fetchAllStocks($stockRepository)
    {
        try {
            return $stockRepository->getAllStocks();
        } catch (\Exception $e) {
            Log::error('Failed to fetch all stocks: ' . $e->getMessage());
            throw new \Exception('Failed to fetch all stocks');
        }
    }

    public function fetchStockBySymbol($symbol)
    {
        try {
            FetchStockPrice::dispatch($symbol);
            $latestStock = Cache::get("stock:{$symbol}");
            $previousStock = Cache::get("stock:{$symbol}");
            $percentageChange = $latestStock && $previousStock ? (($latestStock->close - $previousStock->close) / $previousStock->close) * 100 : 0;

            return [
                'symbol' => $symbol,
                'price' => $latestStock ? $latestStock->close : 'Price not available',
                'percentage_change' => $percentageChange,
                'timestamp' => $latestStock ? $latestStock->timestamp : null,
            ];
        } catch (\Exception $e) {
            Log::error("Failed to fetch stock data for symbol: {$symbol}. Error: " . $e->getMessage());
            throw new \Exception('Failed to fetch stock data');
        }
    }
}
