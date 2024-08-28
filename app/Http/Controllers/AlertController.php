<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Validator;
use Http;
use Illuminate\Support\Facades\Cache;

class AlertController extends Controller
{
    public function sendAlert(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'city' => 'required',
            "state" => 'required',
            "country" => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $data = "";

        if (Cache::has('lat') && Cache::has('long')) {
            $data = [
                "lat" => Cache::get('lat'),
                "long" => Cache::get('long')
            ];
        } else {
            $data = $this->getCoordinatefromCity($request->city, $request->state, $request->country);
            Cache::add("lat", $data['lat'], now()->addHours(4));
            Cache::add("long", $data['long'], now()->addHours(4));
        }
        if (Cache::has('alert')) {
            $value = Cache::get('alert');
            return response()->json($value);
        } else {
            $res = $this->fetchAlert($data['lat'], $data['long']);
            Cache::add('alert', $res, now()->addHours(1));
            return response()->json($res);
        }


        

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
