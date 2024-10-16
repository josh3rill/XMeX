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
        Stock::factory()->create([
            'symbol' => 'AAPL',
            'close' => 150,
            'previous_close' => 145,
            'timestamp' => now(),
        ]);

        // Test API endpoint
        $response = $this->getJson('/api/v1/stocks');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'symbol' => 'AAPL',
        ]);

        // Test frontend view
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('AAPL');
    }
}