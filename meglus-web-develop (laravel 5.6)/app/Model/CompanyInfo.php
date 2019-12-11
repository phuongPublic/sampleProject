<?php

namespace App\Model;

use App\Observers\CompanyInfoObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Services\DefaultService;

class CompanyInfo extends Model
{
    const DEACTIVATED_STATUS = 0;
    const ACTIVATED_STATUS = 1;
    const BLOCKED_STATUS = 9;

    const DELETED_FLG = 1;
    const UNDELETED_FLG = 0;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_info';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'company_id';


    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created'   => CompanyInfoObserver::class,
        'updated'   => CompanyInfoObserver::class,
        'updating'  => CompanyInfoObserver::class,
        'deleted'   => CompanyInfoObserver::class,
        'restored'  => CompanyInfoObserver::class,
        'forceDeleted' => CompanyInfoObserver::class,
    ];

    private $rules = array(
        'company_name'  => 'required|max:20',
        'company_name_en'  => 'required',
        'job_category_cd'  => 'required|numeric',
        'tel'  => 'required|numeric|max:999999999999999',
        'post_cd'  => 'required|numeric|digits:7',
        'prefecture'  => 'required',
        'city1'  => 'required',
        'city2'  => 'required',
        'detail_address'  => 'required',
    );

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'company_name.required' => __('supply.company.company_name_required'),
            'company_name.max' => __('supply.company.company_name_max'),
            'company_name_en.required'  => __('supply.company.company_name_en_required'),
            'job_category_cd.required'  => __('supply.company.job_category_cd_required'),
            'job_category_cd.numeric'  => __('supply.company.job_category_cd_numeric'),
            'tel.required'  => __('supply.company.tel_required'),
            'tel.numeric'  => __('supply.company.tel_numeric'),
            'tel.max'  => __('supply.company.tel_max'),
            'post_cd.required'  => __('supply.common.post_cd_required'),
            'post_cd.numeric'  => __('supply.common.post_cd_numeric'),
            'post_cd.digits'  => __('supply.common.post_cd_digits'),
            'prefecture.required'  => __('supply.company.prefecture_required'),
            'city1.required'  => __('supply.company.city1_required'),
            'city2.required'  => __('supply.company.city2_required'),
            'detail_address.required'  => __('supply.company.detail_address_required'),
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'company_name','company_name_en','job_category_cd', 'tel', 'post_cd', 'prefecture', 'city1', 'city2', 'detail_address',
        'building_name', 'building_name_en', 'max_job_num','status', 'created_id','updated_id','created_at','updated_at','deleted_at'
    ];

    /**
     * Get Owner with the company.
     */
    public function owner()
    {
        return $this->hasOne('App\Model\SupplyUserInfo','id', 'created_id');
    }

    /**
     * Get otpCodes with the company.
     */
    public function otpCodes()
    {
        return $this->hasOne('App\Model\OtpCodes','company_id', 'company_id');
    }

    /**
     * Get Prefecture user with the company.
     */
    public function getPrefecture()
    {
        return $this->hasOne('App\Model\Prefectures','id','prefecture');
    }

    /**
     * Get Job category user with the company.
     */
    public function getJobCategoryMst()
    {
        return $this->hasOne('App\Model\JobCategoryMst','id','job_category_cd');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate($data)
    {
        $validate = Validator::make($data, $this->rules, $this->messages());
        $validate->after(function ($validate) use ($data){
            //会社名（半角英数）を半角英数チェック
            if (!$validate->errors()->has('company_name_en') && !DefaultService::is_hankaku($data['company_name_en'],false))
                $validate->errors()->add('company_name_en', __('supply.company.company_name_en_format'));
            //丁目・番地（半角）を半角チェック
            if (!$validate->errors()->has('detail_address') && !DefaultService::is_hankaku($data['detail_address']))
                $validate->errors()->add('detail_address', __('supply.company.detail_address_format'));
            //建物名（任意・半角英数）を半角英数チェック
            if (!$validate->errors()->has('building_name_en') && (!empty($data['building_name_en']) && !DefaultService::is_hankaku($data['building_name_en'],false)))
                $validate->errors()->add('building_name_en', __('supply.company.building_name_en_format'));
        });
        return $validate;
    }

    public function errors()
    {
        return $this->errors;
    }

    public static function getList($sort, $filter) {
        $model = CompanyInfo::select('company_info.*', 'job_category_mst.name AS job_category_name')
            ->join('job_category_mst', 'job_category_mst.id', '=', 'company_info.job_category_cd');

        if (count($filter) > 0) {
            foreach ($filter as $key => $item) {
                if (($key == 'company_name') && (strlen($item) > 0)) {
                    $model->where('company_info.company_name', 'like', '%' . $item . '%');
                } elseif (($key == 'company_id') && (strlen($item) > 0)) {
                    $model->where('company_info.company_id', '=', $item);
                }
            }
        }

        $sortCondition = ['ASC','DESC'];
        if(count($sort) > 0) {
            foreach ($sort as $key => $item) {
                if(in_array($item, $sortCondition))
                    $model->orderBy('company_info.' .$key, $item);
            }
        }
        return $model->paginate(30);
    }

}
