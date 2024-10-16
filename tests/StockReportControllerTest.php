<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class StockReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $stockSymbols = ["AAPL", "GOOGL", "GOOG", "MSFT", "AMZN", "TSLA", "NVDA", "META", "JPM", "V"];
        $report = [];

        foreach ($stockSymbols as $symbol) {
            $data = [
                'symbol' => $symbol,
                'close' => 150,
                'previous_close' => 145,
                'timestamp' => now()->toDateTimeString(),
            ];
            Cache::shouldReceive('get')
                ->with("stock:{$symbol}")
                ->andReturn($data);

            $report[] = [
                'symbol' => $symbol,
                'price' => $data['close'],
                'previous_close' => $data['previous_close'],
                'percentage_change' => (($data['close'] - $data['previous_close']) / $data['previous_close']) * 100,
                'timestamp' => $data['timestamp'],
            ];
        }

        $response = $this->getJson('/api/v1/stock-report');

        $response->assertStatus(200)
                 ->assertJson($report);
    }

    public function testIndexCacheMiss()
    {
        $stockSymbols = ["AAPL", "GOOGL", "GOOG", "MSFT", "AMZN", "TSLA", "NVDA", "META", "JPM", "V"];
        $report = [];

        foreach ($stockSymbols as $symbol) {
            Cache::shouldReceive('get')
                ->with("stock:{$symbol}")
                ->andReturn(null);

            $report[] = [
                'symbol' => $symbol,
                'price' => 'Price not available',
                'previous_close' => null,
                'percentage_change' => 0,
                'timestamp' => null,
            ];
        }

        $response = $this->getJson('/api/v1/stock-report');

        $response->assertStatus(200)
                 ->assertJson($report);
    }
}