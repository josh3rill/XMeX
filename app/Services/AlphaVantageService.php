<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            Log::info("API response for symbol: {$symbol}", ['response' => $data]); // Log the API response

            if (isset($data['Time Series (1min)'])) {
                $timeSeries = $data['Time Series (1min)'];
                $latestTimestamp = array_key_first($timeSeries);
                $latestData = $timeSeries[$latestTimestamp];

                return [
                    'symbol' => $symbol,
                    'timestamp' => $latestTimestamp,
                    'open' => $latestData['1. open'],
                    'high' => $latestData['2. high'],
                    'low' => $latestData['3. low'],
                    'close' => $latestData['4. close'],
                    'volume' => $latestData['5. volume'],
                ];
            }
        }

        return null;
    }
}