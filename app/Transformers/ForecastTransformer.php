<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class ForecastTransformer extends TransformerAbstract
{
    public function transform($data)
    {
        $hourly_data = $this->getHourly($data);
        $daily_data = $this->getDaily($data);
        return [
            "latitude" => $data['latitude'],
            "longitude" => $data['longitude'],
            "timezone" => $data['timezone'],
            "hourly" => $hourly_data,
            "daily" => $daily_data
        ];
    }

    private function getDaily($data)
    {
        $daily = [];
        foreach ($data['daily']['time'] as $index => $time) {
            $daily[] = [
                "time" => $time,
                "temprature_2m" => $data['daily']['temperature_2m_max'][$index],
            ];
        }

        return $daily;
    }

    private function getHourly($data)
    {
        $hourly = [];

        foreach ($data['hourly']['time'] as $index => $time) {
            $hourly[] = [
                "time" => $time,
                "temprature_2m" => $data['hourly']['temperature_2m'][$index],
                "precipitation_probability" => $data['hourly']['precipitation_probability'][$index],
                "precipitation" => $data['hourly']['precipitation'][$index],
            ];
        }

        return $hourly;
    }
}
