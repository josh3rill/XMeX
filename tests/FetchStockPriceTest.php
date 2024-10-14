<?php

namespace Tests\Unit;

use App\Jobs\FetchStockPrice;
use App\Models\Stock;
use App\Services\AlphaVantageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Mockery;

class FetchStockPriceTest extends TestCase
{
    use RefreshDatabase;

    public function testHandleSuccess()
    {
        
        $symbol = 'AAPL';
        $data = [
            'symbol' => $symbol,
            'timestamp' => now()->toDateTimeString(),
            'close' => 150,
        ];

        $alphaVantageService = Mockery::mock(AlphaVantageService::class);
        $alphaVantageService->shouldReceive('getStockPrice')
            ->with($symbol)
            ->andReturn($data);

        $job = new FetchStockPrice($symbol);

        $this->app->instance(AlphaVantageService::class, $alphaVantageService);

        $job->handle($alphaVantageService);

        $this->assertDatabaseHas('stocks', [
            'symbol' => $symbol,
            'timestamp' => $data['timestamp'],
            'close' => $data['close'],
        ]);
    }

    public function testHandleNoData()
    {
        $symbol = 'AAPL';

        $alphaVantageService = Mockery::mock(AlphaVantageService::class);
        $alphaVantageService->shouldReceive('getStockPrice')
            ->with($symbol)
            ->andReturn(null);

        $job = new FetchStockPrice($symbol);

        $this->app->instance(AlphaVantageService::class, $alphaVantageService);

        Log::shouldReceive('warning')
            ->once()
            ->with("No data returned for symbol: {$symbol}");

        $job->handle($alphaVantageService);

        $this->assertDatabaseMissing('stocks', [
            'symbol' => $symbol,
        ]);
    }

    public function testHandleException()
    {
        $symbol = 'AAPL';

        $alphaVantageService = Mockery::mock(AlphaVantageService::class);
        $alphaVantageService->shouldReceive('getStockPrice')
            ->with($symbol)
            ->andThrow(new \Exception('API error'));

        $job = new FetchStockPrice($symbol);

        $this->app->instance(AlphaVantageService::class, $alphaVantageService);

        Log::shouldReceive('error')
            ->once()
            ->with("Failed to fetch stock price for symbol: {$symbol}. Error: API error");

        $job->handle($alphaVantageService);

        $this->assertDatabaseMissing('stocks', [
            'symbol' => $symbol,
        ]);
    }
}