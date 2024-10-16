<?php

namespace Tests\Unit;

use App\Jobs\UpdateCacheFromDatabase;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Mockery;

class UpdateCacheFromDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function testHandleSuccess()
    {
        $symbol = 'AAPL';
        $stock = Stock::factory()->create(['symbol' => $symbol, 'close' => 150, 'timestamp' => now()]);

        $job = new UpdateCacheFromDatabase($symbol);

        Cache::shouldReceive('put')
            ->once()
            ->with("stock:{$symbol}", Mockery::on(function ($data) use ($stock) {
                return $data['symbol'] === $stock->symbol && $data['close'] === $stock->close;
            }), 60);

        $job->handle();

        $this->assertTrue(true); // If no exceptions are thrown, the test passes
    }

    public function testHandleNoData()
    {
        $symbol = 'AAPL';

        $job = new UpdateCacheFromDatabase($symbol);

        Cache::shouldReceive('put')
            ->never();

        Log::shouldReceive('warning')
            ->once()
            ->with("No stock data found for symbol: {$symbol}");

        $job->handle();

        $this->assertTrue(true); // If no exceptions are thrown, the test passes
    }

    public function testHandleException()
    {
        $symbol = 'AAPL';

        $job = new UpdateCacheFromDatabase($symbol);

        Cache::shouldReceive('put')
            ->andThrow(new \Exception('Cache error'));

        Log::shouldReceive('error')
            ->once()
            ->with("Failed to update cache for symbol: {$symbol}. Error: Cache error");

        $job->handle();

        $this->assertTrue(true); // If no exceptions are thrown, the test passes
    }
}