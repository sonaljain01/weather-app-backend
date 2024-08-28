<?php

namespace App\Http\Controllers;

use App\Transformers\LocationTransformer;
use Cache;
use DB;
use Http;
use Illuminate\Http\Request;
use Validator;

class LocationController extends Controller
{
    // public function getLocation(Request $request)
    // {
    //     // $keys = DB::table('cache')->pluck('key');
    //     // foreach ($keys as $key) {
    //     //     $lat_lon = str_replace("loc:", "", $key);
    //     //     checkifincircle($pair1,par2,radius);
    //     // }

    //     // fetch alert anf save in cache
    //     $alert = Cache::add('loc:27.54,72.39', [
    //         'weather' => [],
    //         'alert' => [],
    //         'forecast' => [],
    //         'history' => []
    //     ], now()->addHours(4));

    //     $data = [
    //         "city" => $request->city,
    //         "state" => $request->state,
    //         "country" => $request->country
    //     ];
    // }

    public function sendDataBasedOnLocation(Request $request)
    {

        if ($request->city == null && $request->state == null && $request->country == null && $request->loc == null) {
            return response()->json([
                "message" => "Please provide atleast any one of city, state, country or loc"
            ]);
        }

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

        $res = $this->getWeather($data['lat'], $data['long']);

        $arr = [$res];

        $response = fractal($arr, new LocationTransformer())->toArray();

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
}
