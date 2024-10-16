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
            $data = $alphaVantageService->getStockPrice($this->symbol);
            if ($data !== null) {
                // Store data in the database
                Stock::updateOrCreate(
                    ['symbol' => $this->symbol, 'timestamp' => $data['timestamp']],
                    $data
                );
            } else {
                Log::warning("No data returned for symbol: {$this->symbol}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to fetch stock price for symbol: {$this->symbol}. Error: ".$e->getMessage());
        }
    }
}
