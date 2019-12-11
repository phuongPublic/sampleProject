<?php
namespace App\Services;
use App\Model\CommutingTime;
use App\Model\DemandUserDevice;
use App\Model\Jobs;
use App\Model\Stations;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Created by PhpStorm.
 * User: truong
 * Date: 18/10/18
 * Time: 5:10 PM
 */
class UtilService {

    /**
     * Generate token for user (before activate)
     * @param $unique_string
     * @return string
     */
    public static function generateToken($unique_string) {
        return $token = sha1($unique_string . Carbon::now()->toDateTimeString());
    }

    /**
     * Calculate distance between all station, then save to database
     *
     * @param $source_station_cd
     * @return bool
     * @throws
     */
    public static function calculateDistanceBetweenStations($source_station_cd) {
        $is_existed = CommutingTime::where('from', $source_station_cd)->count();
        if ($is_existed > 0) return true; // proceeded this station already

        //Get all stations of users and jobs
        $job_stations = Jobs::getDistinctStationCd();
        $user_stations = DemandUserDevice::getDistinctStationCd();
        $station_list = array_merge($job_stations, $user_stations);

        //Get list stations which within 50KM from the above list
        $station_list_within_distance = Stations::getStationListWithinDistance(
            $source_station_cd,
            env('DISTANCE_TO_CALL_MAP_API', 50),
            $station_list
        );

        //Call Google Maps API to get time
        foreach ($station_list_within_distance as $destination_station_cd) {
            // DO NOT proceed if source & destination station are same
            if ($source_station_cd == $destination_station_cd) continue;

            $time = self::getTimeBetweenTwoLocation($source_station_cd, $destination_station_cd);

            if ($time !== false) {
                CommutingTime::createNewRecord($source_station_cd, $destination_station_cd, $time);
            }
        }
    }

    /**
     * Get time between 2 locations
     *
     * @param $from
     * @param $to
     * @return bool|int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getTimeBetweenTwoLocation($from, $to) {
        $from_station = Stations::select('station_name', 'lat', 'lon')->where('station_cd', $from)->first();
        $to_station = Stations::select('station_name', 'lat', 'lon')->where('station_cd', $to)->first();

        $ekispert_url = '';
        if (!empty($from_station->lat) && !empty($from_station->lon) && !empty($to_station->lat) && !empty($to_station->lon)) {
            $ekispert_url = env('EKISPERT') .
                'key=' . env('EKISPERT_KEY') . '&from=' . $from_station->lat . ',' . $from_station->lon .
                '&to=' . $to_station->lat . ',' . $to_station->lon . '&gcs=tokyo';
        }

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $ekispert_url, []);
        } catch (\Exception $exception) {
            Log::error('Get distance error with URL: ' . $ekispert_url);
            Log::error('Get distance error with Message: ' . $exception->getMessage());

            return false;
        }

        $content = json_decode($response->getBody());
        $time = 0;

        if (isset($content->ResultSet->Course->Route->timeOnBoard)) {
            $time = $content->ResultSet->Course->Route->timeOnBoard;
        } elseif (is_array($content->ResultSet->Course)) {
            $time = null;
            foreach ($content->ResultSet->Course as $key => $value) {
                if (is_null($time) || $value->Route->timeOnBoard < $time) {
                    $time = $value->Route->timeOnBoard;
                }
            }
        }

        return $time;
    }
}
