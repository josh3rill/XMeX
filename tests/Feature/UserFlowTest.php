<?php

namespace Tests\Feature;

use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFlowTest extends TestCase
{
    use RefreshDatabase;

    public function testUserFlow()
    {
        // Create stock data
        $stock = Stock::factory()->create(['symbol' => 'AAPL', 'close' => 150, 'previous_close' => 145, 'timestamp' => now()]);

        // Test API endpoint
        $response = $this->getJson('/api/v1/stocks/AAPL');
        $response->assertStatus(200);
        $response->assertJson([
            'symbol' => 'AAPL',
            'price' => 150,
        ]);

        // Test frontend view
        $response = $this->get('/stock-report');
        $response->assertStatus(200);
        $response->assertSee('AAPL');
        $response->assertSee('150');
    }
}
