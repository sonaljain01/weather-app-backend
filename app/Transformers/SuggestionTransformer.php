<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class SuggestionTransformer extends TransformerAbstract
{
    public function transform($data)
    {

        $res = [];
        foreach ($data["results"] as $key => $value) {
            $res[] = [
                'name' => $value["name"] ?? null,
                'city' => $value["city"] ?? null,
                'state' => $value["state"] ?? null,
                'country' => $value["country"] ?? null
            ];
        }
        return [
            'data' => $res
        ];
    }

}
