<?php

namespace App\Jobs;

use App\Services\UpdateCacheService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateCacheFromDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $symbol;
    protected $updateCacheService;

    public function __construct($symbol, UpdateCacheService $updateCacheService)
    {
        $this->symbol = $symbol;
        $this->updateCacheService = $updateCacheService;
    }

    public function handle()
    {
        try {
            $this->updateCacheService->updateCache($this->symbol);
        } catch (\Exception $e) {
            Log::error("Failed to update cache for symbol: {$this->symbol}. Error: " . $e->getMessage());
        }
    }
}
