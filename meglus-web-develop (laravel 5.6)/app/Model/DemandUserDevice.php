<?php

namespace App\Model;

use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Model;

class DemandUserDevice extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
//    protected $table = 'bookmark';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['device_token', 'registration_token', 'os', 'os_version', 'app_version', 'demand_user_id'];

    /**
     * Get all of station cd
     * @return mixed
     */
    public static function getDistinctStationCd() {
        $home_stations = DemandUserInfo::select('home_nearest_station')->distinct()
            ->whereNotNull('home_nearest_station')
            ->get()
            ->toArray();

        $home_stations = array_pluck($home_stations, 'home_nearest_station');

        $school_stations = DemandUserInfo::select('school_nearest_station')->distinct()
            ->whereNotNull('school_nearest_station')
            ->get()
            ->toArray();

        $school_stations = array_pluck($school_stations, 'school_nearest_station');
        $school_stations = array_merge($school_stations, $home_stations);

        return $school_stations;
    }

    /**
     * Push notification
     * @param $demand_user_id
     * @param $title
     * @param string $content
     */
    public static function pushNotificationByUserId($demand_user_id, $title, $content = '') {
        $user_devices = self::select('registration_token')->where('demand_user_id', $demand_user_id)->get()->toArray();
        $user_devices = array_pluck($user_devices, 'registration_token');

        if (count($user_devices) > 0) {
            NotificationService::pushToDevice($user_devices, $title, $content);
        }
    }
}
