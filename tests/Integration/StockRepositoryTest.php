<?php

namespace Tests\Integration;

use App\Models\Stock;
use App\Repositories\StockRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $stockRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stockRepository = $this->app->make(StockRepository::class);
    }

    public function testGetAllStocks()
    {
        Stock::factory()->count(3)->create();
        $stocks = $this->stockRepository->getAllStocks();
        $this->assertCount(3, $stocks);
    }

    public function testGetStockBySymbol()
    {
        $stock = Stock::factory()->create(['symbol' => 'AAPL']);
        $fetchedStock = $this->stockRepository->getStockBySymbol('AAPL');
        $this->assertEquals($stock->id, $fetchedStock->id);
    }

    public function testUpdateStock()
    {
        $data = [
            'timestamp' => now(),
            'open' => 150,
            'high' => 155,
            'low' => 145,
            'close' => 152,
            'volume' => 1000,
            'previous_close' => 148,
        ];
        $this->stockRepository->updateStock('AAPL', $data);
        $stock = Stock::where('symbol', 'AAPL')->first();
        $this->assertEquals(152, $stock->close);
    }
}
