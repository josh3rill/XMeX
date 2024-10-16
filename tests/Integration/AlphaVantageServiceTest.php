<?php

namespace Tests\Integration;

use App\Services\AlphaVantageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AlphaVantageServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testGetStockPrice()
    {
        Http::fake([
            'https://www.alphavantage.co/query*' => Http::response([
                'Time Series (1min)' => [
                    '2024-10-15 16:00:00' => [
                        '1. open' => '150.00',
                        '2. high' => '155.00',
                        '3. low' => '145.00',
                        '4. close' => '152.00',
                        '5. volume' => '1000',
                    ],
                ],
            ], 200),
        ]);

        $service = new AlphaVantageService;
        $data = $service->getStockPrice('AAPL');

        $this->assertNotNull($data);
        $this->assertEquals('AAPL', $data['symbol']);
        $this->assertEquals(152.00, $data['close']);
    }
}
