<?php

namespace App\Model;

use App\Services\SupplyUserInfoService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SupplyUserInfo extends Authenticatable
{
    use SoftDeletes;

    const DEACTIVATED_STATUS = 0;
    const ACTIVATED_STATUS = 1;
    const BLOCKED_STATUS = 9;

    const DELETED_FLG = 1;
    const UNDELETED_FLG = 0;
    const EXPIRE_DAYS = 30;

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
    protected $table = 'supply_user_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login_id', 'company_id', 'password', 'last_name', 'first_name', 'auth_fail_num', 'change_pass_dt', 'token', 'token_expire',
        'status', 'remember_token', 'created_id', 'updated_id', 'created_at', 'updated_at', 'deleted_at', 'del_flg'
    ];

    /**
     * The attributes appends.
     * @var array
     */
    protected $appends  = [
        'company_is_active' => false,
        'company_is_block' => false,
        'company_expire' => null,
        'company_expire_days' => null,
        'company_generation_num' => 0
    ];

    private $errors;

    private $rules = array(
        'last_name'         => 'required|string|max:255',
        'first_name'        => 'required|string|max:255',
        'login_id'          => 'required|email|max:255|unique:supply_user_info',
        'login_id_confirm'  => 'required|same:login_id',
        'password'          => 'required|max:32|min:8',
        'password_confirm'  => 'required|same:password',
    );

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'login_id.required' => trans('supply.register.login_required'),
            'login_id.email'    => trans('supply.register.login_email'),
            'login_id.unique'    => trans('supply.register.login_unique'),
            'login_id_confirm.required'  => trans('supply.register.login_confirm_required'),
            'login_id_confirm.same'  => trans('supply.register.login_confirm_same'),
            'password.required'  => trans('supply.register.pass_required'),
            'password.max'  => trans('supply.register.pass_string'),
            'password.min'  => trans('supply.register.pass_string'),
            'password_confirm.required'  => trans('supply.register.pass_confirm_required'),
            'password_confirm.same'  => trans('supply.register.pass_confirm_same'),
            'last_name.required'  => trans('supply.register.last_name_required'),
            'first_name.required'  => trans('supply.register.first_name_required'),
        ];
    }

    /**
     * Get the company record associated with the user.
     */
    public function companyInfo()
    {
        return $this->hasOne('App\Model\CompanyInfo','company_id', 'company_id');
    }

    /**
     * Get jobs record associated with the user.
     */
    public function jobs()
    {
        return $this->hasMany('App\Model\Jobs','created_id', 'id');
    }

    /**
     * Get the company_is_active attributes.
     * @return int
     */
    public function getCompanyIsActiveAttribute()
    {
        if(isset($this->companyInfo))
            return ($this->companyInfo->status == self::ACTIVATED_STATUS)? true: false;

        return false;
    }

    /**
     * Get the company_is_block attributes.
     * @return int
     */
    public function getCompanyIsBlockAttribute()
    {
        if(isset($this->companyInfo))
            return ($this->companyInfo->status == self::BLOCKED_STATUS)? true: false;

        return false;
    }

    /**
     * Get the company_expire attributes.
     * @return date
     */
    public function getCompanyExpireAttribute()
    {
        if(isset($this->companyInfo) && isset($this->companyInfo->otpCodes))
            return $this->companyInfo->otpCodes->expire_dt;

        return null;
    }

    /**
     * Get the company_expire_days attributes.
     * @return float
     */
    public function getCompanyExpireDaysAttribute()
    {
        if(isset($this->companyInfo) && isset($this->companyInfo->otpCodes)){
            $expireDt       = strtotime($this->companyInfo->otpCodes->expire_dt);
            $now            = strtotime(Carbon::now());
            $datediff       = $expireDt - $now;
            $days           = (int)round($datediff / (60 * 60 * 24), 0, PHP_ROUND_HALF_DOWN);
            return $days;
        }
        return null;
    }

    /**
     * Get the company code generation num attributes.
     * @return int
     */
    public function getCompanyGenerationNumAttribute()
    {
        if(isset($this->companyInfo) && isset($this->companyInfo->otpCodes))
            return (int)$this->companyInfo->otpCodes->generation_num;
        return 0;
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate($data) {
        $validate = Validator::make($data, $this->rules,$this->messages())->after(function ($validator) use ($data){
            if(!$validator->errors()->has('password')){
                $message = SupplyUserInfoService::passwordMatch($data['password']);
                if(strlen($message) > 0)
                    $validator->errors()->add('password', trans('supply.register.pass_charter'));
            }
        });
        return $validate;
    }

    /**
     * Get Supply User Info By Job Id
     *
     * @param $job_id
     * @return mixed
     */
    public static function getSupplyUserInfoByJobId($job_id) {
        return Jobs::select('supply_user_info.login_id', 'supply_user_info.last_name', 'supply_user_info.first_name')
            ->where('jobs.job_id', $job_id)
            ->join('supply_user_info', 'supply_user_info.company_id', 'jobs.company_id')->first();
    }

    public function errors() {
        return $this->errors;
    }

    public static function getUserInfoByLoginId($email) {
        return SupplyUserInfo::where('login_id', $email)->first();
    }

    public static function countUpIfLoginFail(SupplyUserInfo $userInfo) {
        $userInfo->increment('auth_fail_num');
        return true;
    }

    public static function resetAuthFailNum(SupplyUserInfo $userInfo) {
        $userInfo->auth_fail_num = 0;
        $userInfo->save();
        return true;
    }

    public static function getList($sort, $filter) {
        $model = SupplyUserInfo::select('supply_user_info.*')
            ->join('company_info', 'company_info.company_id', '=', 'supply_user_info.company_id');

        if (count($filter) > 0) {
            foreach ($filter as $key => $item) {
                if (($key == 'name') && (strlen($item) > 0)) {
                    $names = explode(" ", $item);
                    $model->where(function ($query) use ($names) {
                        $query->whereIn('first_name', $names);
                        $query->orWhere(function($query) use ($names) {
                            $query->whereIn('last_name', $names);
                        });
                    });
                } elseif (($key == 'login_id') && (strlen($item) > 0)) {
                    $model->where('supply_user_info.login_id', 'like', '%' . $item . '%');
                } elseif (($key == 'company_name') && (strlen($item) > 0)) {
                    $model->where('company_info.company_name', 'like', '%' . $item . '%');
                }
            }
        }

        $sortCondition = ['ASC','DESC'];
        if(count($sort) > 0) {
            foreach ($sort as $key => $item) {
                if($key == 'company_name' && in_array($item, $sortCondition)) {
                    $model->orderBy('company_info.company_name', $item);
                } else {
                    if(in_array($item, $sortCondition))
                        $model->orderBy('supply_user_info.' .$key, $item);
                }
            }
        }
        return $model->paginate(30);
    }
}
