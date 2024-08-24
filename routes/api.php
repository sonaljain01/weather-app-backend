<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\previousWeather;


Route::post("/location", [WeatherController::class, 'sendDataBasedOnLocation']);
Route::post("/history", [previousWeather::class, 'fetchDataBasedOnLocation']);


