<?php

namespace App\Http\Controllers;

use App\Services\StockReportService;

class StockReportController extends Controller
{
    protected $stockReportService;

    public function __construct(StockReportService $stockReportService)
    {
        $this->stockReportService = $stockReportService;
    }

    public function index()
    {
        $stockSymbols = ['AAPL', 'GOOGL', 'GOOG', 'MSFT', 'AMZN', 'TSLA', 'NVDA', 'META', 'JPM', 'V'];
        $report = $this->stockReportService->generateReport($stockSymbols);

        return view('stock_report', ['report' => $report]);
    }
}
