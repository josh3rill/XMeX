<?php

namespace Tests\Unit;

use App\Jobs\FetchStockPrice;
use App\Services\FetchStockPriceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class FetchStockPriceTest extends TestCase
{
    use RefreshDatabase;

    public function testHandleSuccess()
    {
        $symbol = 'AAPL';
        $fetchStockPriceService = $this->createMock(FetchStockPriceService::class);
        $fetchStockPriceService->expects($this->once())
            ->method('fetchStockPrice')
            ->with($symbol);

        $job = new FetchStockPrice($symbol);
        $job->handle($fetchStockPriceService);
    }

    public function testHandleNoData()
    {
        $symbol = 'AAPL';
        $fetchStockPriceService = $this->createMock(FetchStockPriceService::class);
        $fetchStockPriceService->expects($this->once())
            ->method('fetchStockPrice')
            ->with($symbol)
            ->willReturn(null);

        $job = new FetchStockPrice($symbol);
        $job->handle($fetchStockPriceService);
    }

    public function testHandleException()
    {
        $symbol = 'AAPL';
        $fetchStockPriceService = $this->createMock(FetchStockPriceService::class);
        $fetchStockPriceService->expects($this->once())
            ->method('fetchStockPrice')
            ->with($symbol)
            ->willThrowException(new \Exception('Test exception'));

        Log::shouldReceive('error')
            ->once()
            ->with("Failed to fetch stock price for symbol: {$symbol}. Error: Test exception");

        $job = new FetchStockPrice($symbol);
        $job->handle($fetchStockPriceService);
    }
}
