<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;



Route::post("/location", [WeatherController::class, 'sendDataBasedOnLocation']);


