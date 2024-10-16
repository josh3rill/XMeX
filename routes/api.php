<?php

use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('v1/stocks', [StockController::class, 'index']);
Route::get('v1/stocks/{symbol}', [StockController::class, 'show']);
