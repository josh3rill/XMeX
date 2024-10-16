<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class StockReportService
{
    public function generateReport(array $stockSymbols)
    {
        $report = [];
        foreach ($stockSymbols as $symbol) {
            try {
                $data = Cache::get("stock:{$symbol}");
                if (! $data) {
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
                Log::error("Failed to fetch data for symbol: {$symbol}. Error: ".$e->getMessage());
            }
        }

        return $report;
    }

    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return 0;
        }

        return (($current - $previous) / $previous) * 100;
    }
}
