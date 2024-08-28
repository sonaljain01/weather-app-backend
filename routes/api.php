<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PreviousController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\AlertController;


Route::get('/', function () {
    return response()->json(['status' => 'ok', 'time' => now()]);
});

Route::post("location", [LocationController::class, 'sendDataBasedOnLocation']);
Route::post("/history", [PreviousController::class, 'fetchDataBasedOnLocation']);
Route::post("/forecast", [ForecastController::class, 'fetchDataBasedOnLocation']);
Route::post("/alert", [AlertController::class, 'sendAlert']);







