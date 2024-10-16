<?php

namespace App\Console\Commands;

use App\Services\UpdateCacheService;
use Illuminate\Console\Command;

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
