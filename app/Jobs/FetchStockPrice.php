<?php

namespace App\Jobs;

use App\Services\FetchStockPriceService;
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

    public function handle(FetchStockPriceService $fetchStockPriceService)
    {
        try {
            $fetchStockPriceService->fetchStockPrice($this->symbol);
        } catch (\Exception $e) {
            Log::error("Failed to fetch stock price for symbol: {$this->symbol}. Error: " . $e->getMessage());
        }
    }
}
