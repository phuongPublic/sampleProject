<?php

namespace App\Model;

use App\Observers\OtpCodesObserver;
use Illuminate\Database\Eloquent\Model;

class OtpCodes extends Model
{

    const PAGINATE = 30;

    const ACTIVATED_STATUS = 1;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'otp_codes';

    /**
     * The attributes appends  .
     * @var array
     */
    protected $appends  = [
        'expire_from_dt' => null
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'company_id', 'code', 'expire_dt', 'generation_num', 'interaction_user_id',
        'status', 'created_id', 'updated_id', 'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created'   => OtpCodesObserver::class,
        'updated'   => OtpCodesObserver::class,
        'updating'  => OtpCodesObserver::class,
        'deleted'   => OtpCodesObserver::class,
        'restored'  => OtpCodesObserver::class,
        'forceDeleted' => OtpCodesObserver::class,
    ];


    /**
     * Get the expire_from_dt attributes.
     *
     * @return date
     */
    public function getExpireFromDtAttribute()
    {
        if(isset($this->expire_dt)){
            return date('Y-m-d h:i:s',strtotime("-30 day", strtotime($this->expire_dt)));
        }
        return null;
    }

    /**
     * Get the company info record associated with the otp.
     */
    public function otpCompany()
    {
        return $this->hasOne('App\Model\CompanyInfo','company_id', 'company_id');
    }

    /**
     * Get interaction user with the otp.
     */
    public function interactionUser()
    {
        return $this->hasOne('App\Model\SupplyUserInfo','id','interaction_user_id');
    }

    /**
     * Get the company name record associated with the otp.
     * @return string
     */
    public function getCompanyName()
    {
       if(isset($this->otpCompany) && isset($this->otpCompany->company_name))
           return $this->otpCompany->company_name;
       return null;
    }

    /**
     * Get the company name record associated with the otp.
     * @return string
     */
    public function getCompanyDt()
    {
        dd($this->otpCompany->created_at);
       if(isset($this->otpCompany) && isset($this->otpCompany->created_at))
           return $this->otpCompany->created_at->fortmat('Y/m/d');
       return null;
    }

    /**
     * Get otp by active code.
     * @return string
     */
    public static function getOtpByActiveCode($code)
    {
        return self::select()->where('code', $code)->where('status', '<>', self::ACTIVATED_STATUS)->get()->first();
    }

    /**
     * Get otp by active code.
     * @return string
     */
    public static function getList($sort = null)
    {
        $model = self::select('otp_codes.*',
            'company_info.company_name', 'company_info.company_name_en', 'company_info.city1', 'company_info.city2', 'company_info.detail_address',
            'company_info.prefecture AS company_prefecture','company_info.tel AS company_tel','company_info.created_at as company_created_at',
            'supply_user_info.last_name', 'supply_user_info.first_name',
            'interaction_user.id AS interaction_user_id','interaction_user.last_name AS interaction_user_last_name', 'interaction_user.first_name AS interaction_user_first_name'
        )
            ->leftJoin('company_info', 'company_info.company_id', '=', 'otp_codes.company_id')
            ->leftJoin('supply_user_info', 'supply_user_info.company_id', '=', 'company_info.company_id')
            ->leftJoin('supply_user_info AS interaction_user', 'interaction_user.id', '=', 'otp_codes.interaction_user_id');

        if(count($sort) > 0){
            foreach ($sort as $key => $item){
                if($key == 'company_tel' && in_array($item,['ASC','DESC'])){
                    $model->orderBy('company_info.tel', $item);
                }elseif ($key == 'company_owner' && in_array($item,['ASC','DESC']) ){
                    $model->orderBy('supply_user_info.first_name', $item);
                    $model->orderBy('supply_user_info.last_name', $item);
                }elseif ($key == 'company_created' && in_array($item,['ASC','DESC']) ){
                    $model->orderBy('company_info.created_at', $item);
                }elseif ($key == 'owner' && in_array($item,['ASC','DESC']) ){
                    $model->orderBy('interaction_user.first_name', $item);
                    $model->orderBy('interaction_user.last_name', $item);

                }else{
                    if(in_array($item,['ASC','DESC']))
                        $model->orderBy($key, $item);
                }
            }
        }

        return $model->paginate(30);
    }
}
