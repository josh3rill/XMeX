<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSymbolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $stockData = [
            [
                "id" => 2,
                "symbol" => "AAPL",
                "timestamp" => "2024-10-19 15:56:58",
                "open" => "234.870000",
                "high" => "234.890000",
                "low" => "234.810000",
                "close" => "244.860000",
                "previous_close" => "453.000000",
                "volume" => 754,
                "created_at" => "2024-10-19 09:20:22",
                "updated_at" => "2024-10-19 15:52:49"
            ],
            [
                "id" => 3,
                "symbol" => "GOOGL",
                "timestamp" => "2024-10-19 15:57:04",
                "open" => "163.442600",
                "high" => "163.480000",
                "low" => "163.400000",
                "close" => "193.450000",
                "previous_close" => "117.000000",
                "volume" => 733,
                "created_at" => "2024-10-19 09:20:22",
                "updated_at" => "2024-10-19 15:52:50"
            ],
            [
                "id" => 4,
                "symbol" => "GOOG",
                "timestamp" => "2024-10-19 15:57:10",
                "open" => "165.130000",
                "high" => "165.130000",
                "low" => "165.110000",
                "close" => "125.120000",
                "previous_close" => "273.000000",
                "volume" => 94,
                "created_at" => "2024-10-19 09:20:22",
                "updated_at" => "2024-10-19 15:52:51"
            ],
            [
                "id" => 5,
                "symbol" => "MSFT",
                "timestamp" => "2024-10-18 19:59:00",
                "open" => "418.150000",
                "high" => "418.200000",
                "low" => "418.100000",
                "close" => "418.180000",
                "previous_close" => "531.000000",
                "volume" => 109,
                "created_at" => "2024-10-19 09:20:22",
                "updated_at" => "2024-10-19 15:52:51"
            ],
            [
                "id" => 6,
                "symbol" => "AMZN",
                "timestamp" => "2024-10-18 19:59:00",
                "open" => "188.820000",
                "high" => "188.830000",
                "low" => "188.815000",
                "close" => "188.825000",
                "previous_close" => "324.000000",
                "volume" => 956,
                "created_at" => "2024-10-19 09:20:22",
                "updated_at" => "2024-10-19 15:52:52"
            ],
            [
                "id" => 7,
                "symbol" => "TSLA",
                "timestamp" => "2024-10-18 19:59:00",
                "open" => "220.200000",
                "high" => "220.200000",
                "low" => "220.120000",
                "close" => "220.150000",
                "previous_close" => "421.000000",
                "volume" => 4620,
                "created_at" => "2024-10-19 09:20:22",
                "updated_at" => "2024-10-19 15:52:53"
            ],
            [
                "id" => 8,
                "symbol" => "NVDA",
                "timestamp" => "2024-10-18 19:59:00",
                "open" => "137.975000",
                "high" => "138.000000",
                "low" => "137.960000",
                "close" => "138.000000",
                "previous_close" => "193.000000",
                "volume" => 17792,
                "created_at" => "2024-10-19 09:20:22",
                "updated_at" => "2024-10-19 15:52:54"
            ],
            [
                "id" => 9,
                "symbol" => "META",
                "timestamp" => "2024-10-18 19:59:00",
                "open" => "576.600000",
                "high" => "576.600000",
                "low" => "576.150100",
                "close" => "576.600000",
                "previous_close" => "288.000000",
                "volume" => 1138,
                "created_at" => "2024-10-19 09:20:22",
                "updated_at" => "2024-10-19 15:52:55"
            ],
            [
                "id" => 10,
                "symbol" => "JPM",
                "timestamp" => "2024-10-18 19:59:00",
                "open" => "225.399900",
                "high" => "225.399900",
                "low" => "225.399900",
                "close" => "225.399900",
                "previous_close" => "303.000000",
                "volume" => 61,
                "created_at" => "2024-10-19 09:20:22",
                "updated_at" => "2024-10-19 15:52:56"
            ],
            [
                "id" => 11,
                "symbol" => "V",
                "timestamp" => "2024-10-18 19:59:00",
                "open" => "290.450000",
                "high" => "290.540000",
                "low" => "290.450000",
                "close" => "290.540000",
                "previous_close" => "272.000000",
                "volume" => 3,
                "created_at" => "2024-10-19 09:20:22",
                "updated_at" => "2024-10-19 15:52:56"
            ]
        ];

        foreach ($stockData as $data) {
            DB::table('stocks')->insert($data);
        }
    }
}