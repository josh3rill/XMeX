<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class StockSymbolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stockSymbols = [
            "AAPL", "GOOGL", "GOOG", "MSFT", "AMZN", "TSLA", "NVDA", "META", "JPM", "V"
        ];

        foreach ($stockSymbols as $symbol) {
            DB::table('stocks')->insert([
                'symbol' => $symbol,
                'open' => 567.000, // Default value, 
                'high' => 567.000, // Default value, 
                'low' => 567.000, // Default value, 
                'close' => 319.000, // Default value, 
                'previous_close' => 213.000, // Default value, 
                'volume'	=> 1000000, // Default value,
                'timestamp' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
