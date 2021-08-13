<?php
    function computeDistanceBetween($from,$to)
    {
        return computeAngleBetween($from, $to) * 6371009;
    }
    function computeAngleBetween($from, $to)
    {
        return distanceRadians(deg2rad($from['lat']), deg2rad($from['lng']),
        deg2rad($to['lat']), deg2rad($to['lng']));
    }
    function distanceRadians( $lat1,  $lng1,  $lat2,  $lng2) {
        return arcHav(havDistance($lat1, $lat2, $lng1 - $lng2));
    }
    function arcHav($x)
    {
        return 2 * asin(sqrt($x));
    }
    function havDistance($lat1, $lat2, $dLng) {
        return hav($lat1 - $lat2) + hav($dLng) * cos($lat1) * cos($lat2);
    }
     function hav($x) {
        $sinHalf = sin($x * 0.5);
        return $sinHalf * $sinHalf;
    }
?>
