<?php

namespace Tests\Feature;

use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StockReportComponentTest extends TestCase
{
    use RefreshDatabase;

    public function testStockReportComponent()
    {
        $stockSymbols = ['AAPL', 'GOOGL', 'GOOG', 'MSFT', 'AMZN', 'TSLA', 'NVDA', 'META', 'JPM', 'V'];
        foreach ($stockSymbols as $symbol) {
            Stock::factory()->create(['symbol' => $symbol, 'close' => 150, 'previous_close' => 145, 'timestamp' => now()]);
        }

        Livewire::test('stock-report-component')
            ->call('updateStockData')
            ->assertViewHas('report', function ($report) use ($stockSymbols) {
                return count($report) === count($stockSymbols);
            });
    }
}
