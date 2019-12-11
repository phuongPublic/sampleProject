<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stations extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stations';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'station_cd';

    /**
     * Get the company info record associated with the otp.
     */
    public function stationPrefectures()
    {
        return $this->hasOne('App\Model\Prefectures','id', 'pref_cd');
    }

    /**
     * Get the Prefectures record associated with the job.
     */
    public function stationNumber()
    {
        return $this->hasOne('App\Model\StationNumbers','station_cd', 'station_cd');
    }

    /**
     * Get the station line
     */
    public function stationLine()
    {
        return $this->hasOne('App\Model\StationLines','line_cd', 'line_cd');
    }

    /**
     * suggestion station by station name
     *
     * @return object
     */
    static function suggestionStation($name)
    {
        return Stations::all();
    }

    /**
     * Get Station Name by Code
     *
     * @param $station_cd
     * @return mixed
     */
    public static function getStationNameByCode($station_cd) {
        if (empty($station_cd)) return $station_cd;

        $name = Stations::select('station_name')->where('station_cd', $station_cd)->first();
        return ($name['station_name']) ?? null;
    }

    /**
     * Get station list within 50km
     *
     * @param $source_station_cd
     * @param $distance_in_km
     * @param $list_stations
     * @return array
     */
    public static function getStationListWithinDistance($source_station_cd, $distance_in_km, $list_stations) {
        $source_station = Stations::find($source_station_cd);

        $list_stations_query = '';
        if (count($list_stations) > 0 ) {
            $list_stations = join("','", $list_stations);
            $list_stations_query = " WHERE s.station_cd IN ('$list_stations')";
        }


        $query_string = "
            SELECT
                *
            FROM
                (
                    SELECT
                        s.station_cd,
                        p.distance_unit * DEGREES(
                            ACOS(
                                COS(RADIANS(p.latpoint)) * COS(RADIANS(s.lat)) * COS(
                                    RADIANS(p.longpoint) - RADIANS(s.lon)
                                ) + SIN(RADIANS(p.latpoint)) * SIN(RADIANS(s.lat))
                            )
                        ) AS distance_in_km
                    FROM
                        stations AS s
                    JOIN(
                        SELECT
                            ? AS latpoint ,
                            ? AS longpoint ,
                            50.0 AS radius ,
                            111.045 AS distance_unit
                    ) AS p ON 1 = 1
                    {$list_stations_query}
                ) AS tmp
            WHERE
                tmp.distance_in_km < {$distance_in_km}
            ORDER BY
             COALESCE(tmp.distance_in_km , 9999999) ASC
		";

        $parameters[] = $source_station->lat;
        $parameters[] = $source_station->lon;
        $result = DB::select($query_string, $parameters);
        $result = array_pluck($result, 'station_cd');
        return $result;
    }

    public static function getStationsById($id)
    {
        return  self::where('station_cd', $id)->first();
    }


}
