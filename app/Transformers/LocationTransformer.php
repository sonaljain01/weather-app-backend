<?php

namespace App\Transformers;

// use League\Fractal\Resource\Primitive;
use League\Fractal\TransformerAbstract;

class LocationTransformer extends TransformerAbstract
{
    public function transform($data)
    {
        $dailyData = [
            'date' => $data['daily']['time'][0],
            'max_temperature' => $data['daily']['temperature_2m_max'][0],
            'min_temperature' => $data['daily']['temperature_2m_min'][0],
            'sunrise' => $data['daily']['sunrise'][0],
            'sunset' => $data['daily']['sunset'][0],
            'uv_index_max' => $data['daily']['uv_index_max'][0],
        ];

        $hourlyData = $this->transformHourlyData($data);

        return [
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'timezone' => $data['timezone'],
            'elevation' => $data['elevation'],
            'hourly' => $hourlyData,
            'daily' => $dailyData,
        ];
    }

    private function transformHourlyData(array $data)
    {
        $hourly = [];

        if (is_array($data['hourly']['time'])) {
            foreach ($data['hourly']['time'] as $index => $time) {
                $hourly[] = [
                    'time' => $time,
                    'temperature' => $data['hourly']['temperature_2m'][$index] ?? null,
                    'humidity' => $data['hourly']['relative_humidity_2m'][$index] ?? null,
                    'precipitation_probability' => $data['hourly']['precipitation_probability'][$index] ?? null,
                    'precipitation' => $data['hourly']['precipitation'][$index] ?? null,
                    'visibility' => $data['hourly']['visibility'][$index] ?? null,
                    'wind_speed_10m' => $data['hourly']['wind_speed_10m'][$index] ?? null,
                    'wind_speed_80m' => $data['hourly']['wind_speed_80m'][$index] ?? null,
                ];
            }
        }

        return $hourly;
    }

    // public function includeAlert(): Primitive
    // {
    //     $alert = [
    //         'text' => 'foo',
    //         'bar' => 'bvar'
    //     ];

    //     return $this->primitive($alert);
    // }
}
