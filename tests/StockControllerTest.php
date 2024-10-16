<?php

namespace Tests;

use App\Jobs\FetchStockPrice;
use App\Models\Stock;
use App\Repositories\StockRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;

class StockControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $stockRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stockRepository = $this->createMock(StockRepositoryInterface::class);
        $this->app->instance(StockRepositoryInterface::class, $this->stockRepository);
    }

    public function testIndex()
    {
        $stocks = Stock::factory()->count(3)->make();
        $this->stockRepository->method('getAllStocks')->willReturn($stocks);

        $response = $this->getJson('/api/v1/stocks');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function testShow()
    {
        Queue::fake();

        $symbol = 'AAPL';
        $latestStock = Stock::factory()->make(['symbol' => $symbol, 'close' => 150, 'timestamp' => now()]);
        $previousStock = Stock::factory()->make(['symbol' => $symbol, 'close' => 145, 'timestamp' => now()->subMinute()]);

        Cache::shouldReceive('get')
            ->with("stock:{$symbol}")
            ->andReturn($latestStock, $previousStock);

        $response = $this->getJson("/api/v1/stocks/{$symbol}");

        Queue::assertPushed(FetchStockPrice::class, function ($job) use ($symbol) {
            return $job->symbol === $symbol;
        });

        $response->assertStatus(200)
            ->assertJson([
                'symbol' => $symbol,
                'price' => 150,
                'percentage_change' => 3.45,
                'timestamp' => $latestStock->timestamp->toDateTimeString(),
            ]);
    }

    public function testShowNoData()
    {
        Queue::fake();

        $symbol = 'AAPL';

        Cache::shouldReceive('get')
            ->with("stock:{$symbol}")
            ->andReturn(null, null);

        $response = $this->getJson("/api/v1/stocks/{$symbol}");

        Queue::assertPushed(FetchStockPrice::class, function ($job) use ($symbol) {
            return $job->symbol === $symbol;
        });

        $response->assertStatus(200)
            ->assertJson([
                'symbol' => $symbol,
                'price' => 'Price not available',
                'percentage_change' => 0,
                'timestamp' => null,
            ]);
    }
}
