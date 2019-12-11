<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 1/9/2019
 * Time: 11:48 AM
 */

/**
 * Get Latitude/Longitude based on an address
 * @param string $address The address for converting into coordinates
 * @return array An array containing Latitude/Longitude data
 */
function addressToLatLong($address){
    $mapApiKey = env('MAPS_GOOGLE_API_KEY', null);

    $result = ['lat' => 0, 'long' => 0];
    try{
        if ($mapApiKey){
            $address = str_replace(' ','+',$address);
            $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key='.$mapApiKey.'&address='.urlencode($address).'&sensor=false');
            $geo = json_decode($geo, true); // Convert the JSON to an array
            if (isset($geo['status']) && ($geo['status'] == 'OK')) {
                $result['lat'] = $geo['results'][0]['geometry']['location']['lat']; // Latitude
                $result['long'] = $geo['results'][0]['geometry']['location']['lng']; // Longitude
            }
        } else {
            \Illuminate\Support\Facades\Log::error(' error : You must set your API key before using this class!');
        }
    }catch (Exception $e){

    }
    return $result;
}
