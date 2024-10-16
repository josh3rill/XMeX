<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class StockReportController extends Controller
{
    public function index()
    {
        $stockSymbols = ["AAPL", "GOOGL", "GOOG", "MSFT", "AMZN", "TSLA", "NVDA", "META", "JPM", "V"];
        $report = [];

        foreach ($stockSymbols as $symbol) {
            try {
                $data = Cache::get("stock:{$symbol}");
                // Debugging statement
                if (!$data) {
                    // dd("Cache miss for symbol: {$symbol}");
                    Log::warning("Cache miss for symbol: {$symbol}");
                }
                if ($data) {
                    $report[] = [
                        'symbol' => $data['symbol'],
                        'price' => $data['close'],
                        'previous_close' => $data['previous_close'],
                        'percentage_change' => $this->calculatePercentageChange($data['close'], $data['previous_close']),
                        'timestamp' => Carbon::parse($data['timestamp'])->format('Y-m-d H:i:s'),
                   
                    ];
                }
            } catch (\Exception $e) {
                Log::error("Failed to fetch data for symbol: {$symbol}. Error: " . $e->getMessage());
            }
        }
        return view('stock_report', ['report' => $report]);
    }

    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return 0;
        }
        return (($current - $previous) / $previous) * 100;
    }
}