<?php

namespace App\Repositories;

interface StockRepositoryInterface
{
    public function getAllStocks();
    public function getStockBySymbol($symbol);
    public function updateStock($symbol, $price);
}