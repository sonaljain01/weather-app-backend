<?php

if (!function_exists('checkisinCircle')) {
    function checkisinCircle($dataSent)
    {
        $lat_rad = deg2rad((float) $dataSent['lat']);
        $long_rad = deg2rad((float) $dataSent['long']);
        $lata_rad = deg2rad((float) $dataSent['lata']);
        $longa_rad = deg2rad((float) $dataSent['longa']);
        $lat_diff = $lat_rad - $lata_rad;
        $long_diff = $long_rad - $longa_rad;

        // haversine formula

        $a = sin($lat_diff / 2) * sin($lat_diff / 2) +
            cos($lat_rad) * cos($lata_rad) *
            sin($long_diff / 2) * sin($long_diff / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = 6371000 * $c;

        return $distance <= 200;
    }
}
