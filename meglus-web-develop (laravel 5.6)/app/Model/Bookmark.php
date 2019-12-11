<?php

namespace App\Model;

use App\Services\DefaultService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bookmark extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bookmark';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['demand_user_id', 'job_id', 'checked_flg'];

    public function job() {
        return $this->belongsTo('App\Model\Jobs', 'job_id', 'job_id');
    }

    /**
     * Get bookmark job list by user
     * @param $demand_user_id
     * @return mixed
     */
    public static function getBookmarkListByUser($demand_user_id) {
        $bookmark = Bookmark::selectRaw('jobs.*')
            ->join('jobs', 'jobs.job_id', 'bookmark.job_id')
            ->whereIn('jobs.status', [Jobs::ACTIVATED_STATUS, Jobs::DEACTIVATED_STATUS, Jobs::REOPEN_STATUS])
            ->where('demand_user_id', $demand_user_id)
            ->get();

        return $bookmark;
    }

    /**
     * Get bookmark job list by user with Sort
     * @param $demand_user_id
     * @param $filter_sorts
     * @return mixed
     */
    public static function getBookmarkListByUserWithSort($demand_user_id, $filter_sorts = []) {
        $user = session('demand_user');

        //get jobs list which user has applied before
        $applied_jobs = Applicant::select('job_id')->where('demand_user_id', $demand_user_id)->get()->pluck('job_id')->toArray();

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

        $result = Bookmark::selectRaw($selected_column)
            ->with(['job.jobWorkingTime' => function($query) {
                $query->selectRaw('job_id, time_option, day, DATE_FORMAT(start_time, "%H:%i") as start_time, DATE_FORMAT(end_time, "%H:%i") as end_time');
            }])
            ->join('jobs', 'jobs.job_id', 'bookmark.job_id')
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
            })
            ->whereIn('jobs.status', [Jobs::ACTIVATED_STATUS, Jobs::DEACTIVATED_STATUS, Jobs::REOPEN_STATUS])
            ->whereNotIn('jobs.job_id', $applied_jobs)
            ->where('demand_user_id', $demand_user_id)
            ->join('stations', 'stations.station_cd', 'jobs.workplace_nearest_station_cd')
            ->leftJoin('station_lines', 'stations.line_cd', 'station_lines.line_cd')
            ->leftJoin('station_numbers', 'stations.station_cd', 'station_numbers.station_cd');

        DefaultService::addSortAndFilterForJobsListApi($result, $filter_sorts);

        $bookmark = $result->paginate(env('WATCH_TRASH_LIST_LIMITATION', 20))->toArray();
        foreach ($bookmark['data'] as $key => $value) {
            if (key_exists('school_nearest_station_move_time', $value)) {
                $bookmark['data'][$key]['movement_time'] = $value['school_nearest_station_move_time'];
            } elseif (key_exists('home_nearest_station_move_time', $value)) {
                $bookmark['data'][$key]['movement_time'] = $value['home_nearest_station_move_time'];
            } else {
                $bookmark['data'][$key]['movement_time'] = null;
            }

            if (isset($value['job']['job_working_time'])) {
                foreach ($value['job']['job_working_time'] as $k => $v) {
                    $bookmark['data'][$key]['job_working_time'][$v['time_option']]['start_time'] = $v['start_time'];
                    $bookmark['data'][$key]['job_working_time'][$v['time_option']]['end_time'] = $v['end_time'];
                    $bookmark['data'][$key]['job_working_time'][$v['time_option']]['days'][] = $v['day'];
                }

                $bookmark['data'][$key]['job_working_time'] = array_values($bookmark['data'][$key]['job_working_time']);
            }

            unset($bookmark['data'][$key]['job']);
        }

        return $bookmark['data'];
    }
}
