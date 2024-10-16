<?php
$cacheKey = 'alpha_vantage_requests';
$requestCount = Cache::get($cacheKey, 0);

if ($requestCount >= $this->rateLimit) {
    Log::warning('Alpha Vantage API rate limit reached.');
    return null; // Or handle this scenario as needed
}

try {
    $response = $this->client->get("https://www.alphavantage.co/query", [
        'query' => [
            'function' => 'TIME_SERIES_INTRADAY',
            'symbol' => $symbol,
            'interval' => '1min',
            'apikey' => $this->apiKey,
        ]
    ]);

    $data = json_decode($response->getBody(), true);

    if (!isset($data['Time Series (1min)'])) {
        Log::error('Invalid response from Alpha Vantage API.', ['response' => $data]);
        return null;
    }

    $timeSeries = $data['Time Series (1min)'];
    $latestTimestamp = array_key_first($timeSeries);
    $latestData = $timeSeries[$latestTimestamp];

    // Get the previous timestamp and data
    $previousTimestamp = array_keys($timeSeries)[1] ?? null;
    $previousData = $previousTimestamp ? $timeSeries[$previousTimestamp] : null;

    // Increment the request count
    Cache::put($cacheKey, $requestCount + 1, 60);

    return [
        'symbol' => $symbol,
        'latest' => $latestData,
        'previous' => $previousData,
    ];
} catch (\Exception $e) {
    Log::error('Failed to fetch data from Alpha Vantage API.', ['error' => $e->getMessage()]);
    return null;
}