<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UpdateCacheService;

class UpdateCacheCommand extends Command
{
    protected $signature = 'cache:update';
    protected $description = 'Update Cache From Database';

    protected $updateCacheService;

    public function __construct(UpdateCacheService $updateCacheService)
    {
        parent::__construct();
        $this->updateCacheService = $updateCacheService;
    }

    public function handle()
    {
        $this->updateCacheService->updateAllCaches();
    }
}