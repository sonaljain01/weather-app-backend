<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\previousWeather;
use App\Http\Controllers\forecastWeather;
use App\Http\Controllers\alertController;


Route::get('/', function() {
    return response()->json(['status' => 'ok', 'time' => now()]);
});

Route::post("location", [LocationController::class, 'sendDataBasedOnLocation']);

Route::post("/history", [previousWeather::class, 'fetchDataBasedOnLocation']);
Route::post("/forecast", [forecastWeather::class, 'fetchDataBasedOnLocation']);
Route::post("/alert", [alertController::class, 'sendAlert']);







