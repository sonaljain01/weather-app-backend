<?php

namespace App\Http\Controllers;

use App\Transformers\LocationTransformer;
use Cache;
use DB;
use Http;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function sendDataBasedOnLocation(Request $request)
    {

        if ($request->city == null && $request->state == null && $request->country == null && $request->loc == null) {
            return response()->json([
                "message" => "Please provide atleast any one of city, state, country or loc"
            ]);
        }

        $keys = DB::table('cache')->pluck('key');

        $data = [];
        if ($request->loc != null) {
            sscanf($request->loc, "%[^,],%[^,]", $lat, $long);
            $data = [
                "lat" => $lat,
                "long" => $long
            ];
        } else {
            $data = $this->getCoordinatefromCity($request->city, $request->state, $request->country);
        }
        $locationKey = 'loc: ' . $data['lat'] . ',' . $data['long'];
        if (Cache::has($locationKey)) {
            $cache = Cache::get($locationKey);
            if (!empty($cache["weather"])) {
                return response()->json($cache['weather']);
            }
        }

        foreach ($keys as $key) {
            $lat_lon = str_replace("loc: ", "", $key);
            sscanf($lat_lon, "%[^,],%[^,]", $lata, $longa);
            $dataSent = [
                "long" => $data['long'],
                "lat" => $data['lat'],
                "longa" => $longa,
                "lata" => $lata,
            ];
            if (checkisinCircle($dataSent)) {
                $cache = Cache::get($key);
                if (!empty($cache["weather"])) {
                    return response()->json($cache["weather"]);
                }
            }
        }

        $res = $this->getWeather($data['lat'], $data['long']);
        $alert = $this->fetchAlert($data['lat'], $data['long']);
        $arr = [$res];
        $response = fractal($arr, new LocationTransformer())->toArray();


        $cache = Cache::get($locationKey);

        if (empty($cache)) {
            $cache = [
                "weather" => $response,
                "alert" => $alert
            ];
            $cache = Cache::add($locationKey, $cache, now()->addHours(4));
            return response()->json($response);
        }
        $dataSet = [];
        if (empty($cache["forecast"])) {
            $dataSet = [
                'history' => $cache['history'] ?? null,
                "weather" => $response,
                "alert" => $alert
            ];
        }
        if (empty($cache["history"])) {
            $dataSet = [
                "weather" => $response,
                "alert" => $alert,
                "forecast" => $cache["forecast"] ?? null
            ];
        }

        $cache = Cache::put($locationKey, $dataSet, now()->addHours(4));

        return response()->json($response);
    }

    public function getCoordinatefromCity(string $city, string $state, string $country)
    {

        $ninja_api_url = config("api.ninja_api_url");
        $ninja_api_key = config("api.ninja_api_key");

        $lat = "";
        $long = "";

        try {
            $response = Http::withHeader(
                'X-Api-Key',
                $ninja_api_key
            )->get("$ninja_api_url?city=$city&country=$country");

            foreach ($response->json() as $res) {
                $validdata = $state;
                if ($res['state'] == $validdata) {
                    $lat = $res['latitude'];
                    $long = $res['longitude'];
                    $data = [
                        "lat" => $lat,
                        "long" => $long
                    ];
                    return $data;
                }
            }

        } catch (\Exception $e) {
            echo "<pre>";
            print_r($e);
            echo "</pre>";
        }

    }

    public function getWeather(string $lat, string $long)
    {
        $api_base_url = config("api.api_base_url");
        $wind_speed_80m = config("api.wind_speed_80m");
        $wind_speed_10m = config("api.wind_speed_10m");
        $precipitation = config("api.precipitation");
        $precipitation_probability = config("api.precipitation_probability");
        $relative_humidity = config("api.relative_humidity");
        $temprature = config("api.temprature");
        $visibility = config("api.visibility");

        try {

            $response = Http::withHeaders([
                "Content-Type" => "application/json",
            ])->get("$api_base_url?latitude=$lat&longitude=$long&hourly=$temprature,$relative_humidity,$precipitation_probability,$precipitation,$visibility,$wind_speed_10m,$wind_speed_80m&daily=temperature_2m_max,temperature_2m_min,sunrise,sunset,uv_index_max&forecast_days=1&timezone=Asia%2FKolkata");


            return $response->json();

        } catch (\Exception $e) {
            echo "<pre>";
            print_r($e);
            echo "</pre>";
        }

    }
    public function fetchAlert(string $lat, string $long)
    {
        $weather_api_url = config("api.weather_api_url");
        $weather_api_key = config("api.weather_api_key");

        try {
            $url = "$weather_api_url/current.json?key=$weather_api_key&q=$lat,$long&alert=yes";
            $res = Http::get($url);

            $alerts = $res->json()['alerts'] ?? null;

            if ($alerts) {
                return ['message' => $alerts];
            } else {
                return ['message' => 'No alert found'];
            }
        } catch (\Exception $e) {
            return ['error' => 'An error occurred while fetching the alert'];
        }
    }
}
