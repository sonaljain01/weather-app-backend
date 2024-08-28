<?php
return [
    'api_base_url' => env('API_BASE_URL', "NOAPPURL"),
    'ninja_api_key' => env('NINJA_API_KEY', "NOAPIKEY"),
    'ninja_api_url' => env('NINJA_API_URL', "NOAPIURL"),
    "weather_api_url" => env('WEATHER_API_URL', "NOWeatherAPIURL"),
    "weather_api_key" => env('WEATHER_API_KEY', "NOWeatherAPIKEY"),
    "geo_api_key" => env('GEO_APIFY_KEY', "NOGeoAPIKEY"),
    "geo_api_url" => env('GEO_APIFY_URL', "NOGeoAPIURL"),
    "temprature" => "temperature_2m",
    "relative_humidity" => "relative_humidity_2m",
    "precipitation_probability" => "precipitation_probability",
    "precipitation" => "precipitation",
    "visibility" => "visibility",
    "wind_speed_10m" => "wind_speed_10m",
    "wind_speed_80m" => "wind_speed_80m"
];
