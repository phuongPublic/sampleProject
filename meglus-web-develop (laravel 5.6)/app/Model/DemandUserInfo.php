<?php

namespace App\Model;

use App\Services\DefaultService;
use App\Services\UtilService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class DemandUserInfo extends Authenticatable
{
    const DEACTIVATED_STATUS = 0;
    const ACTIVATED_STATUS = 1;
    const BLOCKED_STATUS = 9;
    const BLOCKED_APPLY = 8;

    const DELETED_FLG = 1;
    const UNDELETED_FLG = 0;

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'demand_user_info';

    private $errors;

    private $rules = array(
        'mail'          => 'required|email|max:255',
    );

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facebook_id','mail','token','token_expire_dt','birth_day','name','profile_path',
        'nationality_cd','gender','home_nearest_station','home_nearest_station_move_time','school_nearest_station','school_nearest_station_move_time',
        'post_cd','prefecture','city1','city2','detail_address','tel','japanese_level',
        'important1_cd','important2_cd','important3_cd',
        'work_start_time','work_end_time',
        'work_experience1_category_cd','work_experience1_discription_cd',
        'work_experience2_category_cd','work_experience2_discription_cd',
        'work_experience3_category_cd','work_experience3_discription_cd',
        'status','created_id','updated_id','created_at','updated_at','deleted_at'
    ];

    /**
     * The attributes appends  .
     * @var array
     */
    protected $appends  = [
        'is_home_station' => null,
        'is_school_station'    => null,
    ];


    /**
     * Get Prefecture user with the company.
     */
    public function getPrefecture()
    {
        return $this->hasOne('App\Model\Prefectures','id','prefecture');
    }

    /**
     * Get Prefecture user with the company.
     */
    public function getDevices()
    {
        return $this->hasMany('App\Model\DemandUserDevice','demand_user_id','id');
    }

    /**
     * Get demand user residences .
     */
    public function getResidences($demand_user_id)
    {
        return  DemandUserResidence::where('demand_user_id', $demand_user_id)->get();
    }

    /**
     * Get demand user residences .
     */
    public function residences()
    {
        return $this->hasMany('App\Model\DemandUserResidence','demand_user_id','id');
    }

    /**
     * Get demand user work day .
     */
    public function getWorkDays($demand_user_id)
    {
        return  DemandUserWorkDay::where('demand_user_id', $demand_user_id)->get();
    }

    /**
     * Get demand user work day .
     */
    public function workDays()
    {
        return $this->hasMany('App\Model\DemandUserWorkDay','demand_user_id','id');
    }



    /**
     * Get the Station record associated with the job.
     */
    public function getHomeNearestStation()
    {
        return $this->hasOne('App\Model\Stations','station_cd', 'home_nearest_station');
    }

    /**
     * Get the  school_nearest_station
     */
    public function getSchoolNearestStation()
    {
        return $this->hasOne('App\Model\Stations','station_cd', 'school_nearest_station');
    }


    /**
     * Get demand user work experience .
     */
    public function getWorkExpWithFieldName($id, $fieldNo, $fieldType)
    {
        $fieldName = 'work_experience'.$fieldNo.'_'.$fieldType;
        return  DemandUserResidence::where($fieldName, $id)->first();
    }

    /**
     * Get the appends home station attributes.
     *
     * @return bool
     */
    public function getIsHomeStationAttribute()
    {
        $station = DefaultService::stationLabelByCd($this->home_nearest_station);
        if(isset($station->label))
            return $station->label;
        return null;
    }

    /**
     * Get the appends home station attributes.
     *
     * @return bool
     */
    public function getIsSchoolStationAttribute()
    {
        $station = DefaultService::stationLabelByCd($this->school_nearest_station);
        if(isset($station->label))
            return $station->label;
        return null;
    }


    public function messages()
    {
        return [
            'mail.required' => trans('supply.register.login_required'),
            'mail.email'    => trans('supply.register.login_email'),
        ];
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate($data) {

        $validate = Validator::make($data, $this->rules,$this->messages());
        return $validate;
    }

    public function errors() {
        return $this->errors;
    }

    /**
     * Get user information by mail
     * @param $mail
     * @return mixed
     */
    public static function getUserInfoByMail($mail) {
        return DemandUserInfo::where('mail', $mail)->first();
    }

    /**
     * Issue (generate) new token for user
     * @param $user_object
     * @param $mail
     * @return mixed|string
     */
    public static function issueToken($user_object, $mail) {
        if (!$user_object) {
            $user_object = new DemandUserInfo();
            $user_object->mail = $mail;
        }

        $user_object->token = UtilService::generateToken($mail);
        $user_object->token_expire_dt = Carbon::now()->addDay();
        $user_object->save();

        return $user_object->token;
    }

    /**
     * Get user info by Facebook Id
     * If facebook id is not exist in system, then, create new record
     *
     * @param $facebook_id
     * @return DemandUserInfo
     */
    public static function getUserInfoByFacebookId($facebook_id) {
        $user = DemandUserInfo::where('facebook_id', $facebook_id)->first();

        if ($user) return $user;

        $user = new DemandUserInfo();
        $user->facebook_id = $facebook_id;
        $user->status = self::ACTIVATED_STATUS;
        $user->save();
        return $user;
    }

    /**
     * Get user info by user id
     *
     * @param $id
     * @return mixed
     */
    public static function getUserInfoById($id) {
        return  self::where('id', $id)->first();
    }

    /**
     * Update User Information
     * @param DemandUserInfo $user_object
     * @param array $requested_data
     *
     * @return mixed
     */
    public static function updateUser(DemandUserInfo $user_object, Array $requested_data) {
        foreach ($requested_data as $key => $value) {
            if ($key == 'residence_status_cd') {
                DemandUserResidence::insertNew($user_object->id, $value);
                continue;
            }

            if ($key == 'work_day') {
                DemandUserWorkDay::insertNew($user_object->id, $value);
                continue;
            }

            if ($key == 'profile') {
                $path = base_path() . env('USER_IMAGE_PATH', 'user_image') . $user_object->id;

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $image = Image::make($value);
                $image->orientate();
                $imageName = time() . uniqid() . '.' . $value->getClientOriginalExtension();
                $image->save($path . DIRECTORY_SEPARATOR . $imageName);
                $user_object->profile_path = $imageName;
                continue;
            }

            if ($key == 'age') {
                $user_object->birth_day = Carbon::now()->subYears($value)->format('Y') . '-01-01';
                continue;
            }

            $user_object->{$key} = $value;

            if ($key == 'school_nearest_station' || $key == 'home_nearest_station') {
                UtilService::calculateDistanceBetweenStations($value);
            }
        }

        //delete info if null
        $data_for_remove = ['post_cd', 'prefecture', 'city1', 'city2', 'detail_address', 'tel','mail', 'important1_cd',
            'important2_cd', 'important3_cd', 'japanese_level', 'work_start_time', 'work_end_time'];
        foreach ($data_for_remove as $value) {
            if (!isset($requested_data[$value])) $user_object->{$value} = null;
        }

        if (!isset($requested_data['residence_status_cd'])) {
            DemandUserResidence::where('demand_user_id', $user_object->id)->delete();
        }

        if (!isset($requested_data['work_day'])) {
            DemandUserWorkDay::where('demand_user_id', $user_object->id)->delete();
        }

        $user_object->save();
        return $user_object;
    }

    /**
     * Get User Info
     * @param DemandUserInfo $user
     * @return array
     */
    public static function getUserInfoForApi(DemandUserInfo $user) {
        $data = [];
        $data['id'] = $user->id;
        $data['name'] = $user->name;
        $data['age'] = empty($user->birth_day) ? env('DEFAULT_AGE') : Carbon::createFromFormat('Y-m-d', $user->birth_day)->diffInYears();
        $data['nationality_cd'] = empty($user->nationality_cd) ? env('DEFAULT_COUNTRY_CD') : $user->nationality_cd;
        $data['gender'] = (int)$user->gender;
        $data['home_nearest_station'] = $user->home_nearest_station;
        $data['home_nearest_station_name'] = Stations::getStationNameByCode($user->home_nearest_station);
        $data['home_nearest_station_move_time'] = empty($user->home_nearest_station_move_time) ? env('DEFAULT_MOVE_TIME') : $user->home_nearest_station_move_time * 1;
        $data['school_nearest_station'] = $user->school_nearest_station;
        $data['school_nearest_station_name'] = Stations::getStationNameByCode($user->school_nearest_station);
        $data['school_nearest_station_move_time'] = empty($user->school_nearest_station_move_time) ? env('DEFAULT_MOVE_TIME') : $user->school_nearest_station_move_time * 1;
        $data['post_cd'] = $user->post_cd;
        $data['prefecture'] = $user->prefecture;
        $data['city1'] = $user->city1;
        $data['city2'] = $user->city2;
        $data['detail_address'] = $user->detail_address;
        $data['tel'] = $user->tel;
        $data['mail'] = $user->mail;

        $residence = DemandUserResidence::where('demand_user_id', $user->id)->get();
        $data['residence_status_cd'] = array_pluck($residence, 'qualification');
        $data['japanese_level'] = $user->japanese_level;

        $workday = DemandUserWorkDay::where('demand_user_id', $user->id)->get();
        $data['work_day'] = array_pluck($workday, 'day');
        $data['work_start_time'] = $user->work_start_time;
        $data['work_end_time'] = $user->work_end_time;
        $data['important1_cd'] = $user->important1_cd;
        $data['important2_cd'] = $user->important2_cd;
        $data['important3_cd'] = $user->important3_cd;
        $data['work_experience1_category_cd'] = $user->work_experience1_category_cd;
        $data['work_experience1_discription_cd'] = $user->work_experience1_discription_cd;
        $data['work_experience2_category_cd'] = $user->work_experience2_category_cd;
        $data['work_experience2_discription_cd'] = $user->work_experience2_discription_cd;
        $data['work_experience3_category_cd'] = $user->work_experience3_category_cd;
        $data['work_experience3_discription_cd'] = $user->work_experience3_discription_cd;
        $data['avatar'] = $user->profile_path;

        return $data;
    }


    /**
     * Admin det list
     * @param $sort
     * @param $filter
     * @return DemandUserInfo[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getList($sort = [], $filter = []){

        $model = self::select();
        if(count($filter) > 0){
            foreach ($filter as $key => $item){
                if($key == 'name_mail') {
                    if(strlen($item) > 0)
                        $model->where(function ($query) use ($item) {
                            $query->orWhere('name', 'like', '%'.$item . '%')
                                ->orWhere('mail', 'like', '%'.$item . '%');
                        });
                }elseif($key == 'nationality_cd' && (int)$item > 0){
                    $model->where($key, $item);
                }elseif($key == 'gender' && $item != ''){
                    $model->where($key, $item);
                }else{
                    if($item != '')
                        $model->where($key, 'like','%'.$item .'%');
                }
            }

        }

        if(count($sort) > 0){
            foreach ($sort as $key => $item){
                if(in_array($item,['ASC','DESC']))
                    $model->orderBy($key, $item);
            }
        }

        return $model->paginate(30);
    }
}
