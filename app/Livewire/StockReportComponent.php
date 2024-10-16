<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\StockReportService;

class StockReportComponent extends Component
{
    public $report = [];
    protected $stockReportService;

    public function mount(StockReportService $stockReportService)
    {
        $this->stockReportService = $stockReportService;
        $this->updateStockData();
    }

    public function updateStockData()
    {
        $stockSymbols = ['AAPL', 'GOOGL', 'GOOG', 'MSFT', 'AMZN', 'TSLA', 'NVDA', 'META', 'JPM', 'V'];
        $this->report = $this->stockReportService->generateReport($stockSymbols);
    }

    public function render()
    {
        return view('livewire.stock-report-component', ['report' => $this->report]);
    }

    public function refreshTable()
    {
        $this->updateStockData();
    }
}