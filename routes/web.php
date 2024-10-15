<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockReportController;

// Route::get('/', function () { return view('welcome');});

 Route::get('/', [StockReportController::class, 'index']);