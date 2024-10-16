<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Repositories\StockRepositoryInterface;
use App\Services\StockService;

class StockController extends Controller
{
    protected $stockService;

    protected $stockRepository;

    public function __construct(StockService $stockService, StockRepositoryInterface $stockRepository)
    {
        $this->stockService = $stockService;
        $this->stockRepository = $stockRepository;
    }

    public function index()
    {
        try {
            $stocks = $this->stockService->fetchAllStocks($this->stockRepository);

            return response()->json($stocks);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($symbol)
    {
        try {
            $stockData = $this->stockService->fetchStockBySymbol($symbol);

            return response()->json($stockData);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
