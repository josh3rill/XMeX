<?php

namespace Tests\Unit;

use App\Jobs\UpdateCacheFromDatabase;
use App\Services\UpdateCacheService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UpdateCacheFromDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function testHandleSuccess()
    {
        $symbol = 'AAPL';
        $updateCacheService = $this->createMock(UpdateCacheService::class);
        $updateCacheService->expects($this->once())
            ->method('updateCache')
            ->with($symbol);

        $job = new UpdateCacheFromDatabase($symbol, $updateCacheService);
        $job->handle();
    }

    public function testHandleNoData()
    {
        $symbol = 'AAPL';
        $updateCacheService = $this->createMock(UpdateCacheService::class);
        $updateCacheService->expects($this->once())
            ->method('updateCache')
            ->with($symbol)
            ->willReturn(null);

        $job = new UpdateCacheFromDatabase($symbol, $updateCacheService);
        $job->handle();
    }

    public function testHandleException()
    {
        $symbol = 'AAPL';
        $updateCacheService = $this->createMock(UpdateCacheService::class);
        $updateCacheService->expects($this->once())
            ->method('updateCache')
            ->with($symbol)
            ->willThrowException(new \Exception('Test exception'));

        Log::shouldReceive('error')
            ->once()
            ->with("Failed to update cache for symbol: {$symbol}. Error: Test exception");

        $job = new UpdateCacheFromDatabase($symbol, $updateCacheService);
        $job->handle();
    }
}
