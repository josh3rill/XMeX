<?php

use App\Http\Controllers\StockReportController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () { return view('welcome');});

Route::get('/', [StockReportController::class, 'index']);
