<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Http;
use App\Transformers\SuggestionTransformer;

class SuggestionController extends Controller
{
    public function suggestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required | string | max:255 | min:3',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $res = $this->fetchSuggestion($request->data);
        $arr = [$res];
        $response = fractal($arr, new SuggestionTransformer())->toArray();

        return response()->json($response);
    }

    public function fetchSuggestion(string $data)
    {
        try {
            $api_key = config('api.geo_api_key');
            $api_url = config('api.geo_api_url');
            $response = Http::get("$api_url?text=$data&format=json&apiKey=$api_key");
        } catch (\Exception $e) {
            echo "<pre>";
            print_r($e);
            echo "</pre>";
        }

        return $response->json();
    }
}
