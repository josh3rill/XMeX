<?php

namespace App\Jobs;

use App\Services\AlphaVantageService;
use App\Models\Stock;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $data = $alphaVantageService->getStockPrice($this->symbol);
        if ($data !== null) {
            // Store data in the database
            Stock::updateOrCreate(
                ['symbol' => $this->symbol, 'timestamp' => $data['timestamp']],
                $data
            );
        }
    }
}