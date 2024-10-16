<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AlphaVantageService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.alphavantage.key');
    }

    public function getStockPrice($symbol)
    {
        $response = Http::get('https://www.alphavantage.co/query', [
            'function' => 'TIME_SERIES_INTRADAY',
            'symbol' => $symbol,
            'interval' => '1min',
            'apikey' => $this->apiKey,
            
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Process the data as needed
            return $data;
        }

        return null;
    }
}
