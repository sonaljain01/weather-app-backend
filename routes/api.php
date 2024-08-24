<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\previousWeather;
use App\Http\Controllers\forecastWeather;


Route::post("/location", [WeatherController::class, 'sendDataBasedOnLocation']);
Route::post("/history", [previousWeather::class, 'fetchDataBasedOnLocation']);
Route::post("/forecast", [forecastWeather::class, 'fetchDataBasedOnLocation']);






