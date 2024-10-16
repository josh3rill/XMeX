<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\StockReportController;

class StockReportComponent extends Component
{
    public $report = [];

    protected $stockController;

    public function __construct()
    {
        $this->stockController = new StockReportController();
    }

    public function mount()
    {
        $this->updateStockData();
    }

    public function updateStockData()
    {
        $this->report = $this->stockController->index()->getData()['report'];
    }

    public function render()
    {
        return view('livewire.stock-report', [
            'report' => $this->report
        ]);
    }

    public function refreshTable()
    {
        $this->updateStockData();
    }
}