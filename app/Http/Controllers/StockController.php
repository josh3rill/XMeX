<?php

namespace App\Http\Controllers;

use App\Repositories\StockRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Jobs\FetchStockPrice;
use App\Models\Stock;

class StockController extends Controller
{
    protected $stockRepository;

    public function __construct(StockRepositoryInterface $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    public function index()
    {
        try {
            $stocks = $this->stockRepository->getAllStocks();
            return response()->json($stocks);
        } catch (\Exception $e) {
            Log::error('Failed to fetch all stocks: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to fetch all stocks'], 500);
        }
    }

    public function show($symbol)
    {
        try {
            // Dispatch a job to fetch the stock price
            FetchStockPrice::dispatch($symbol);

            // Retrieve the latest stock data from the cache
            $latestStock = Cache::get("stock:{$symbol}");
            $previousStock = Cache::get("stock:{$symbol}");

            if ($latestStock && $previousStock) {
                $percentageChange = (($latestStock->close - $previousStock->close) / $previousStock->close) * 100;
            } else {
                $percentageChange = 0;
            }

            return response()->json([
                'symbol' => $symbol,
                'price' => $latestStock ? $latestStock->close : 'Price not available',
                'percentage_change' => $percentageChange,
                'timestamp' => $latestStock ? $latestStock->timestamp : null,
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to fetch stock data for symbol: {$symbol}. Error: " . $e->getMessage());
            return response()->json(['message' => 'Failed to fetch stock data'], 500);
        }
    }
}