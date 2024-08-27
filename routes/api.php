<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PreviousWeather;
use App\Http\Controllers\ForecastWeather;
use App\Http\Controllers\AlertController;


Route::get('/', function () {
    return response()->json(['status' => 'ok', 'time' => now()]);
});

Route::post("location", [LocationController::class, 'sendDataBasedOnLocation']);
Route::post("/history", [PreviousWeather::class, 'fetchDataBasedOnLocation']);
Route::post("/forecast", [ForecastWeather::class, 'fetchDataBasedOnLocation']);
Route::post("/alert", [AlertController::class, 'sendAlert']);







