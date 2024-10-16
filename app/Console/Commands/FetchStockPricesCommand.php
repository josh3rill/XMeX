<?php

namespace App\Console\Commands;

use App\Services\FetchStockPriceService;
use Illuminate\Console\Command;

class FetchStockPricesCommand extends Command
{
    protected $signature = 'stocks:fetch';

    protected $description = 'Fetch stock prices for predefined symbols and store in database';

    protected $fetchStockPriceService;

    public function __construct(FetchStockPriceService $fetchStockPriceService)
    {
        parent::__construct();
        $this->fetchStockPriceService = $fetchStockPriceService;
    }

    public function handle()
    {
        $this->fetchStockPriceService->fetchAllStockPrices();
    }
}
