<?php
namespace App\Services;
use App\Model\Applicant;
use App\Model\CodeMst;
use App\Model\CompanyInfo;
use App\Model\JobCategoryMst;
use App\Model\Jobs;
use App\Model\MinimumWages;
use App\Model\OtpCodes;
use App\Model\PostCodeMst;
use App\Model\Prefectures;
use App\Model\Stations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
/**
 * Created by PhpStorm.
 * User: Quan Lee
 * Date: 11/9/2018
 * Time: 10:36 AM
 */

class DefaultService {

    const UNSET_VAL = [
        ''
    ];

    const UNSET_CITY1 = [
        ''
    ];

    const UNSET_CITY2 = [
        '','以下に掲載がない場合'
    ];

    /**
     * Function make prefecture tree.
     * @return array
     */
    public static function makePrefectureTree()
    {
        //Cache::flush('cache_prefecture');
        $results = Cache::rememberForever('cache_prefecture', function () {
            $prefectures = PostCodeMst::select('prefecture','city1','city2')->get();
            $results = [];
            foreach ($prefectures as $key => $prefecture ){
                //$prefecture->city2 = preg_replace("/\（[^)]+\）/","",$prefecture->city2);
                $arr = explode("（", $prefecture->city2, 2);
                $prefecture->city2 = $arr[0];

                if(in_array($prefecture->city2,self::UNSET_CITY2) || strpos($prefecture->city2, '）'))
                    continue;

                $results[$prefecture->prefecture][$prefecture->city1][$prefecture->city2] = $prefecture->city2;
            }
            return $results;
        });
        return $results;
    }

    /**
     * Get address by post code
     * @return array
     */
    public static function getAddress($code)
    {
        //Cache::flush('post_cd_'.$code);
        $results = Cache::rememberForever('post_cd_'.$code, function () use ($code){
            $result =  file_get_contents('http://zipcloud.ibsnet.co.jp/api/search?zipcode=' . $code);
            $result = json_decode($result, true);
            if($result && $result['results'][0]){
                if($prefcode     = $result['results'][0]['prefcode'])
                    $result['attach_city1'] = self::getCtyByPrefecture($prefcode);

                if($city           = $result['results'][0]['address2'])
                    $result['attach_city2'] = self::getCty2ByCityName($city);
            }
            return $result;

        });
        return $results;
    }

    /**
     * Function get only prefecture.
     * @return array
     */
    public static function getPrefecture()
    {
        //Cache::flush('prefecture_only');
        $results = Cache::rememberForever('prefecture_only', function () {
            $prefectures = Prefectures::select('id','name')->get();
            $results = [];
            foreach ($prefectures as $key => $prefecture ){
                if(in_array($prefecture->name,self::UNSET_VAL))
                    continue;
                $results[$prefecture->id] = $prefecture->name;
            }
            return $results;
        });
        return $results;
    }

    /**
     * Function get minimum wages of prefecture.
     * @return array
     */
    public static function getMinimumWagesPrefecture()
    {
        //Cache::flush('wages_prefecture');
        $results = Cache::rememberForever('wages_prefecture', function () {
            $results = [];
            $rows = MinimumWages::getMinimumWagesPrefecture();
            if(count($rows) > 0)
                $results = array_column($rows->toArray(), 'amount','pref_cd');
            return $results;
        });
        return $results;
    }

    /**
     * Function get city by prefecture name
     * @return array
     */
    public static function getCtyByPrefecture($prefecture)
    {
        //Cache::flush('city1_'.$prefecture);
        $results = Cache::rememberForever('city1_'.$prefecture, function () use ($prefecture) {
            $prefectures = PostCodeMst::select('city1')
                ->join('prefectures', function ($join) use ($prefecture) {
                    $join->on('prefectures.name', '=', 'post_code_mst.prefecture')
                        ->where('prefectures.id', '=', $prefecture);
                })->where('city1','<>','')->whereNotNull('city1')
                ->distinct('city1')->get();

            $results = [];
            foreach ($prefectures as $key => $prefecture ){
                if(in_array($prefecture->city1,self::UNSET_CITY1))
                    continue;
                $results[$prefecture->city1] = $prefecture->city1;
            }

            if(count($results) > 0 )
                $results = array_values($results);
            return $results;

        });

        return $results;
    }

    /**
     * @param $demandId
     * @param $supplyId
     * @return mixed
     */
    public static function checkUserAppliedThisJob($demandId, $supplyId)
    {
        $applied = DB::table('applicant')
            ->join('jobs', function($join) use ($demandId, $supplyId)
            {
                $join->on('applicant.job_id', '=', 'jobs.job_id')
                    ->where('jobs.created_id', '=', $supplyId);
            })
            ->where('applicant.demand_user_id','=',$demandId)
            ->first();
        return $applied;
    }

    /**
     * Function get city2 by city name
     * @return array
     */
    public static function getCty2ByCityName($name, $prefecture = null)
    {
        //Cache::flush('city2_'.$name);
        $results = Cache::rememberForever('city2_by_prefecturename_'.$prefecture.'_city1'.$name, function () use ($name,$prefecture){
            $city = PostCodeMst::select('city2');
            if($prefecture)
                $city->where('prefecture',$prefecture);
            $rows = $city->where('city1',$name)->where('city2','<>','')->whereNotNull('city2')->distinct('city2')->get();
            $results = [];
            foreach ($rows as $key => $item ){
                $results[$item->city2] = $item->city2;
            }
            if(count($results) > 0 )
                $results = array_values($results);

            return $results;
        });
        return $results;
    }

    /**
     * Function suggestion Station by Station name
     * @return array
     */
    public static function suggestionStation($name)
    {
        //Cache::flush('cache_station_'.$name);
        //$results = Cache::rememberForever('cache_station_'.$name, function () use ($name) {
            $stations = Stations::select('stations.station_cd','stations.station_name','stations.station_name_r',
                'station_lines.line_name','station_numbers.station_number', 'station_lines.line_color_c','prefectures.name as prefecture_name'
                   //DB::raw('CONCAT(stations.station_name," ",station_lines.line_name," ",station_numbers.station_number,"（",prefectures.name,"）") as label'),
                   //DB::raw('CONCAT(stations.station_name_r," ",station_lines.line_name," ", station_numbers.station_number,"（",prefectures.name,"）") as label_r')
                )
                ->leftJoin('prefectures', 'prefectures.id', '=', 'stations.pref_cd')
                ->leftJoin('station_lines', 'station_lines.line_cd', '=', 'stations.line_cd')
                ->leftJoin('station_numbers', 'station_numbers.station_cd', '=', 'stations.station_cd')
                ->where(function ($query) use ($name) {
                    $query->orWhere('stations.station_name', 'like', $name .'%')
                            ->orWhere('stations.station_name_k', 'like', $name .'%')
                            ->orWhere('stations.station_name_r', 'like', $name .'%')
                            ->orWhere('stations.station_cd', 'like', $name .'%');
                })
                //->where('stations.station_name_index', 'like', $name .'%')
                ->limit(10)->get()->reduce(function ($carry, $item){
                    $carry[$item->station_cd]['id']                = $item->station_cd;
                    $carry[$item->station_cd]['label']             = $item->station_name.' '.$item->line_name.' '.$item->station_number.' ('.$item->prefecture_name.')';
                    $carry[$item->station_cd]['label_r']           = $item->station_name_r.' '.$item->line_name.' '.$item->station_number.' ('.$item->prefecture_name.')';
                    $carry[$item->station_cd]['station_number']    = $item->station_number;
                    $carry[$item->station_cd]['line_color_c']      = $item->line_color_c;
                    $carry[$item->station_cd]['station_name']      = $item->station_name;
                    $carry[$item->station_cd]['station_name_r']    = $item->station_name_r;
                    $carry[$item->station_cd]['line_name']         = $item->line_name;
                    $carry[$item->station_cd]['prefectures_name']  = $item->prefecture_name;

                    return $carry;
                },[]);
            return $stations;

            $results = [];
            foreach ($stations as $key => $station ){
                $results[$key]['id']                = $station->station_cd;
                $results[$key]['label']             = $station->station_name.' '.$station->line_name.' '.$station->station_number.' ('.$station->prefecture_name.')';
                $results[$key]['label_r']           = $station->station_name_r.' '.$station->line_name.' '.$station->station_number.' ('.$station->prefecture_name.')';
                $results[$key]['station_number']    = $station->station_number;
                $results[$key]['line_color_c']      = $station->line_color_c;
                $results[$key]['station_name']      = $station->station_name;
                $results[$key]['station_name_r']    = $station->station_name_r;
                $results[$key]['line_name']         = $station->line_name;
                $results[$key]['prefectures_name']  = $station->prefecture_name;
            }
            return $results;
        //});
        //return $results;
    }

    /**
     * Function Station label by cd
     * @return array
     */
    public static function stationLabelByCd($cd)
    {
        //Cache::flush('cache_station_label_by_cd_'.$cd);
        $results = Cache::rememberForever('cache_station_label_by_cd_'.$cd, function () use ($cd) {
            $stations = Stations::select('stations.station_cd','stations.station_name','stations.station_name_r',
                'station_lines.line_name','station_numbers.station_number', 'station_lines.line_color_c','prefectures.name as prefecture_name'
            //DB::raw('CONCAT(stations.station_name," ",station_lines.line_name," ",station_numbers.station_number,"（",prefectures.name,"）") as label'),
            //DB::raw('CONCAT(stations.station_name_r," ",station_lines.line_name," ",station_numbers.station_number,"（",prefectures.name,"）") as label_r')
            )
                ->leftJoin('prefectures', 'prefectures.id', '=', 'stations.pref_cd')
                ->leftJoin('station_lines', 'station_lines.line_cd', '=', 'stations.line_cd')
                ->leftJoin('station_numbers', 'station_numbers.station_cd', '=', 'stations.station_cd')
                ->where('stations.station_cd', $cd)
                ->groupBy('stations.station_cd')->first();
            if($stations){
                $stations->label = $stations->station_name.' '.$stations->line_name.' '.$stations->station_number.'（'.$stations->prefecture_name.'）';
                $stations->label_r = $stations->station_name_r.' '.$stations->line_name.' '.$stations->station_number.'（'.$stations->prefecture_name.'）';
            }
            return $stations;
        });
        return $results;
    }

    /**
     * function get get ReasonCd
     * @param array $group
     * @param bool $getVal
     * @return array
     */
    public static function getReasonCd($group = ['cancel_acceptance_reason_cd','cancel_employment_reason_cd','cancel_application_reason_cd'], $getVal = true)
    {
        return self::getCodeMstByGroup($group, $getVal);
    }

    /**
     * Function get code mst by key
     * @return array
     */
    public static function getCodeMstByGroup($group = null, $getVal = false)
    {
        $string = $group; // default string
        if(is_array($group))
            $string = implode('_', $group);

        //Cache::flush('code_mst_'.((int)$getVal).'_'.$string);
        $results = Cache::rememberForever('code_mst_'.((int)$getVal).'_'.$string, function () use ($group, $getVal)  {
            $codes = CodeMst::select('code_mst.*');

            if($group && $group != '' && is_string($group))
                $codes = $codes->where('group', $group);

            if($group && is_array($group))
                $codes = $codes->whereIn('group', $group);

            $codes = $codes->orderBy('seq')->get();
            if($getVal == true){
                $result = $codes->pluck('label','value')->toArray();
                return $result;
            }

            return $codes;
        });
        return $results;
    }

    /**
     * Function get code mst by key (FOR MULTIPLE LANGUAGE)
     * @return array
     */
    public static function getCodeMstByGroupForMulLanguage($group = null)
    {
        // Clear all cache for Test. Todo: remove later
        // Cache::flush();
        $labels = collect(explode(',', env('COUNTRY_LIST_FOR_MUL_LANG')))->reduce(function ($carry, $item) use ($group) {
            if($item == 'jp')
                $carry[$group] = 'label';
            else
                $carry[$group . '_' . $item] = 'label_' . $item;
            return $carry;
        },[]);

        return Cache::rememberForever('code_mst_' . $group, function () use ($labels)  {
            $results = CodeMst::select('group','value','label', 'img_path')
                            ->whereIn('group', array_keys($labels))
                            ->orderBy('seq')
                            ->get()
                            ->reduce(function ($carry, $item) use ($labels) {
                                if(empty($carry[$item->value]))
                                    $carry[$item->value] = ['value' => $item->value, 'img_path' => $item->img_path];
                                $carry[$item->value][$labels[$item->group]] = $item->label;
                                
                                return $carry;
                            },[]);
            return array_values($results);
        });
    }

    /**
     * Function suggestion Station by Station name
     * @param Request $data
     * @return array
     */
    public static function jobValidate($data)
    {
        $model = new Jobs();
        return $model->validate($data->all());
    }

    public static function validate($data, $modelName)
    {
        $model = new CompanyInfo();
        return $model->validate($data->all());
    }

    /**
     * Function get category tree
     * @return array
     */
    public static function jobCategoryTree()
    {
        //Cache::flush('job_category_tree');
        $results = Cache::rememberForever('job_category_tree', function () {
            $result = self::builCategoryArray();
            return $result;
        });

        return $results;
    }

    /**
     * Function get category all
     * @return array
     */
    public static function jobCategoryAll()
    {
        //Cache::flush('job_category_all');
        $results = Cache::rememberForever('get_job_category_all', function () {
            $result = [];
            $rows = JobCategoryMst::select('id','category_cd','name','icon_filepath','display_order','del_flg')
                ->orderBy('display_order')
                ->where('del_flg',0)->get();

            if(count($rows) > 0)
                $result = array_column($rows->toArray(), 'name', 'id');
            return $result;
        });
        return $results;
    }

    /**
     * Function get category all
     * @return array
     */
    public static function jobCategories()
    {
        $rows = JobCategoryMst::select('id','category_cd','name','icon_filepath','display_order','del_flg')
            ->orderBy('display_order')
            ->where('del_flg',0)->get();

        return $rows;
    }

    /**
     * Function Job Working Time passer
     * @return array
     */
    public static function jobWorkingTime($jobWorkingTime = null)
    {
        $results = [];
        if(count($jobWorkingTime)> 0){
            foreach ($jobWorkingTime as $key => $item){
                if(!isset($results[$item->time_option]))
                    $results[$item->time_option] = ['day' => [], 'start_time' => null, 'end_time' => null];

                $results[$item->time_option]['day'][$item->day]       = $item->day;
                $results[$item->time_option]['start_time']  = date('H:i', strtotime($item->start_time));
                $results[$item->time_option]['end_time']    = date('H:i', strtotime($item->end_time));
            }
        }
        return $results;
    }

    public static function builCategoryArray($multiple_language_flg = false)
    {
        $sourceArr = JobCategoryMst::select('id','category_cd','name','icon_filepath','display_order','del_flg')
            ->orderBy('display_order')
            ->where('del_flg',0)->get();
        $resultArr  = [];
        $parents    = 0;

        // Get job_category_mst for multiple language
        if ($multiple_language_flg) {
            $job_category_mst_mul_lang = DefaultService::getCodeMstByGroupForMulLanguage('job_category_cd');

            $converted_job_category_mst_mul_lang = [];
            foreach ($job_category_mst_mul_lang as $key => $value) {
                $converted_job_category_mst_mul_lang[$value['value']] = $value;
            }
        }

        // get parent
        if(count($sourceArr) > 0){
            foreach ($sourceArr as $key => $value) {
                if ((int)$value['category_cd'] == $parents) {
                    $resultArr[$value['id']] = [
                        'id'            => $value['id'],
                        'category_cd'   => (int)$value['category_cd'],
                        'level'         => 1,
                        'name'          => $value['name'],
                        'icon_filepath' => $value['icon_filepath'],
                        'display_order' => $value['display_order'],
                        'del_flg'       => $value['del_flg'],
                        'items'          => []
                    ];
                    unset($sourceArr[$key]);
                }
            }
        }

        // get child
        if(count($sourceArr) > 0){
            foreach ($sourceArr as $key => $value) {
                if(isset($resultArr[(int)$value['category_cd']])){
                    $resultArr[(int)$value['category_cd']]['items'][(int)$value['id']] = [
                        'id'            => $value['id'],
                        'category_cd'   => (int)$value['category_cd'],
                        'level'         => 2,
                        'name'          => $value['name'],
                        'icon_filepath' => $value['icon_filepath'],
                        'display_order' => $value['display_order'],
                        'del_flg'       => $value['del_flg']
                    ];

                    unset($sourceArr[$key]);
                }
            }
        }

        if ($multiple_language_flg) {
            $language_list = explode(',', env('COUNTRY_LIST_FOR_MUL_LANG'));
            unset($language_list[0]);

            foreach ($resultArr as $key => $value) {
                foreach ($language_list as $val) {
                    if (isset($converted_job_category_mst_mul_lang[$value['id']]['label_' . $val])) {
                        $resultArr[$key]['name_'.$val] = $converted_job_category_mst_mul_lang[$value['id']]['label_' . $val];
                    }

                    if (isset($value['items']) && count($value['items']) > 0) {
                        foreach ($value['items'] as $k => $v) {
                            foreach ($language_list as $v2) {
                                if (isset($converted_job_category_mst_mul_lang[$v['id']]['label_' . $v2])) {
                                    $resultArr[$key]['items'][$k]['name_' . $v2] = $converted_job_category_mst_mul_lang[$v['id']]['label_' . $v2];
                                }
                            }
                        }
                    }
                }
            }
        }

        return $resultArr;
    }

    // 各半角チェック
    public static function is_hankaku($str, $include_kana = true, $include_controls = true, $encoding = null)
    {
        if (!$include_controls && !ctype_print($str)) {
            return false;
        }

        if (is_null($encoding)) {
            $encoding = mb_internal_encoding();
        }
        if ($include_kana) {
            $to_encoding = 'SJIS';
        } else {
            $to_encoding = 'UTF-8';
        }
        $str = mb_convert_encoding($str, $to_encoding, $encoding);

        if (strlen($str) === mb_strlen($str, $to_encoding)) {
            return true;
        } else {
            return false;
        }

        return false;
    }

    /**
     * Function Job Working Time passer
     * @return array
     */
    public static function getCompanyAddress() {
        $results = [
            'message' => __('validation.job.not_company'),
            'results'  => null,
            'status'  => 400
        ];

        $company = isset(Auth::user()->companyInfo)?Auth::user()->companyInfo->toArray():null;
        if($company) {
            $results['results'] = $company;
            $results['status'] = 200;
            $results['message'] = '';

            $results['attach_city1'] = self::getCtyByPrefecture($company['prefecture']);
            $results['attach_city2'] = self::getCty2ByCityName($company['city1']);
        }

       return $results;
    }

    /**
     * Function get company code
     * @return string
     */
    public static function makeOtpCode() {
        $code   = strtoupper(str_random(8));
        $row    = OtpCodes::where('code',$code)->get();
        if(count($row) == 0)
            return $code;
        return self::makeOtpCode();
    }

    /**
     * Apple Sort & Filter logic for Jobs List API (Jobs list, Watch list, Trash list)
     *
     * @param &$query
     * @param $filter_sorts
     */
    public static function addSortAndFilterForJobsListApi(&$query, $filter_sorts) {
        if (isset($filter_sorts->salary_sort) && $filter_sorts->salary_sort == 'asc') {
            $query->orderBy('jobs.min_salary', 'asc')->orderBy('jobs.max_salary', 'asc');
        } elseif (isset($filter_sorts->salary_sort) && $filter_sorts->salary_sort == 'desc') {
            $query->orderBy('jobs.max_salary', 'desc')->orderBy('jobs.min_salary', 'desc');
        }

        //if not isset school_station_sort, sort by home as the default
        if (isset($filter_sorts->school_station_sort) && $filter_sorts->school_station_sort == 'asc') {
            $query->orderBy(DB::raw('COALESCE(school_nearest_station_move_time, 99999)'), 'asc');
        } elseif (isset($filter_sorts->school_station_sort) && $filter_sorts->school_station_sort == 'desc') {
            $query->orderBy(DB::raw('COALESCE(school_nearest_station_move_time, 99999)'), 'desc');
        } else {
            $query->orderBy(DB::raw('COALESCE(home_nearest_station_move_time, 99999)'), 'asc');
        }

        //start filter
        if (isset($filter_sorts->job_categories_filter) && is_array($filter_sorts->job_categories_filter) && count($filter_sorts->job_categories_filter) > 0) {
            $query->whereIn('jobs.job_category_cd', $filter_sorts->job_categories_filter);
        }

        //japanese_level
        if (isset($filter_sorts->japanese_level_filter) && is_array($filter_sorts->japanese_level_filter) && count($filter_sorts->japanese_level_filter) > 0) {
            $query->whereIn('jobs.japanese_level', $filter_sorts->japanese_level_filter);
        }

        if (isset($filter_sorts->min_salary_filter) && $filter_sorts->min_salary_filter > 0) {
            $query->where('jobs.min_salary', '>=', $filter_sorts->min_salary_filter);
        }

        if (isset($filter_sorts->important_things_filter) && is_array($filter_sorts->important_things_filter) && count($filter_sorts->important_things_filter) > 0) {
            $string_for_sort = implode(',', $filter_sorts->important_things_filter);

            $query->where(function($query) use ($filter_sorts) {
                $query->whereIn('jobs.important1_cd', $filter_sorts->important_things_filter);
                $query->orWhereIn('jobs.important2_cd', $filter_sorts->important_things_filter);
                $query->orWhereIn('jobs.important3_cd', $filter_sorts->important_things_filter);
            })
            ->orderByRaw('
                CASE
                    WHEN (jobs.important1_cd IN ('.$string_for_sort.') AND jobs.important2_cd IN ('.$string_for_sort.') AND jobs.important3_cd IN ('.$string_for_sort.')) THEN 3
                    WHEN (jobs.important1_cd IN ('.$string_for_sort.') AND jobs.important2_cd IN ('.$string_for_sort.'))
                        OR (jobs.important1_cd IN ('.$string_for_sort.') AND jobs.important3_cd IN ('.$string_for_sort.'))
                        OR (jobs.important2_cd IN ('.$string_for_sort.') AND jobs.important3_cd IN ('.$string_for_sort.')) THEN 2
                    WHEN (jobs.important1_cd IN ('.$string_for_sort.') OR jobs.important2_cd IN ('.$string_for_sort.') OR jobs.important3_cd IN ('.$string_for_sort.')) THEN 1
                    ELSE 0
                END DESC
            ');
        }
    }

    /**
     * Generate SQL query for movement time calculation
     *
     * @param $time_column_name
     * @param $station_name
     * @param $user_object
     * @return string
     */
    public static function generateSqlQueryForMovementTime($time_column_name, $station_name, $user_object) {
        if (empty($user_object->{$station_name})) return ', (null) as ' . $time_column_name;

        return '
            , (
                SELECT times + '. $user_object->{$time_column_name} .' + workplace_nearest_station_move_time AS times
                FROM commuting_times
                WHERE `from` = `jobs`.workplace_nearest_station_cd AND `to` = ' . $user_object->{$station_name} . ' LIMIT 1
            ) as ' . $time_column_name;
    }
}
