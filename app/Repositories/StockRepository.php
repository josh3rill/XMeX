<?php

namespace App\Repositories;

use App\Models\Stock;

class StockRepository implements StockRepositoryInterface
{
    public function getAllStocks()
    {
        return Stock::all();
    }

    public function getStockBySymbol($symbol)
    {
        return Stock::where('symbol', $symbol)->first();
    }

    public function updateStock($symbol, $data)
    {
        $stock = Stock::firstOrNew(['symbol' => $symbol, 'timestamp' => $data['timestamp']]);
        $stock->open = $data['open'];
        $stock->high = $data['high'];
        $stock->low = $data['low'];
        $stock->close = $data['close'];
        $stock->volume = $data['volume'];
        $stock->previous_close = $data['previous_close'];
        $stock->save();
    }
}