<?php

namespace App\Model;

use App\Services\DefaultService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Trash extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trash';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['demand_user_id', 'job_id', 'checked_flg'];

    /**
     * Get trash job list by user
     * @param $demand_user_id
     * @return mixed
     */
    public static function getTrashListByUser($demand_user_id) {
        $bookmark = Trash::selectRaw('jobs.*')
            ->join('jobs', 'jobs.job_id', 'trash.job_id')
            ->whereIn('jobs.status', [Jobs::ACTIVATED_STATUS, Jobs::DEACTIVATED_STATUS, Jobs::REOPEN_STATUS])
            ->where('trash.checked_flg', '0')
            ->where('demand_user_id', $demand_user_id)
            ->get();

        return $bookmark;
    }

    /**
     * Get trash job list by user with Sort
     *
     * @param $filter_sorts
     * @param $demand_user_id
     * @return mixed
     */
    public static function getTrashListByUserWithSort($demand_user_id, $filter_sorts = []) {
        $user = session('demand_user');
        $selected_column = '`jobs`.job_id, `jobs`.workplace_name, `jobs`.workplace_name_en, `jobs`.job_category_cd,
            `jobs`.application_method, `jobs`.min_salary, `jobs`.max_salary, `jobs`.japanese_level,
            `jobs`.workplace_nearest_station_cd, `stations`.station_name, `stations`.station_name_r,
            `jobs`.`important1_cd`, `jobs`.important2_cd, `jobs`.important3_cd, `station_lines`.line_name,
            `station_numbers`.station_number, `station_lines`.line_color_c,
            `jobs`.workplace_nearest_station_move_time as movement_time';

        $selected_column .= DefaultService::generateSqlQueryForMovementTime(
            'home_nearest_station_move_time',
            'home_nearest_station',
            $user
        );

        if (isset($filter_sorts->school_station_sort) && in_array($filter_sorts->school_station_sort, ['asc', 'desc'])) {
            $selected_column .= DefaultService::generateSqlQueryForMovementTime(
                'school_nearest_station_move_time',
                'school_nearest_station',
                $user
            );
        }

        $result = Trash::selectRaw($selected_column)
            ->join('jobs', 'jobs.job_id', 'trash.job_id')
            ->whereIn('jobs.status', [Jobs::ACTIVATED_STATUS, Jobs::DEACTIVATED_STATUS, Jobs::REOPEN_STATUS])
            ->where('demand_user_id', $demand_user_id)
            ->where('checked_flg', '0')
            ->join('stations', 'stations.station_cd', 'jobs.workplace_nearest_station_cd')
            ->leftJoin('station_lines', 'stations.line_cd', 'station_lines.line_cd')
            ->leftJoin('station_numbers', 'stations.station_cd', 'station_numbers.station_cd')
            ->join('company_info', function($join) {
                $join->on('jobs.company_id', '=', 'company_info.company_id');
            })
            ->join('supply_user_info', function($join) {
                $join->on('supply_user_info.company_id', '=', 'company_info.company_id');
            })
            ->where(function ($query) {
                $query->where('company_info.status', '!=', DB::raw(CompanyInfo::BLOCKED_STATUS));
                $query->orWhere(function($query) {
                    $query->where('company_info.status', '=', DB::raw(CompanyInfo::DEACTIVATED_STATUS));
                    $query->where('company_info.created_at', '>=', Carbon::now()->subDays(30));
                });
            })
            ->where(function ($query) {
                $query->where('supply_user_info.status', '=', DB::raw(SupplyUserInfo::ACTIVATED_STATUS));
                $query->orWhere(function($query) {
                    $query->where('supply_user_info.status', '=', DB::raw(SupplyUserInfo::DEACTIVATED_STATUS));
                    $query->where('supply_user_info.created_at', '>=', Carbon::now()->subDays(30));
                });
            });

        DefaultService::addSortAndFilterForJobsListApi($result, $filter_sorts);

        $trash_list = $result->paginate(env('WATCH_TRASH_LIST_LIMITATION', 20))->toArray();
        foreach ($trash_list['data'] as $key => $value) {
            if (key_exists('school_nearest_station_move_time', $value)) {
                $trash_list['data'][$key]['movement_time'] = $value['school_nearest_station_move_time'];
            } elseif (key_exists('home_nearest_station_move_time', $value)) {
                $trash_list['data'][$key]['movement_time'] = $value['home_nearest_station_move_time'];
            } else {
                $trash_list['data'][$key]['movement_time'] = null;
            }
        }

        return $trash_list['data'];
    }
}
