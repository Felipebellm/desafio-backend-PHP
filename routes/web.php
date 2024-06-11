<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CurrencyIsoController;

Route::get('/', [HomeController::class, 'index']);
Route::post('/fetch-currency', [CurrencyIsoController::class, 'fetchCurrency']);
