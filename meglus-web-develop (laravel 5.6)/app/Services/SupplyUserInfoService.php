<?php
namespace App\Services;
use App\Model\CompanyInfo;
use App\Model\OtpCodes;
use App\Model\SupplyUserInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Psy\Util\Json;

/**
 * Created by PhpStorm.
 * User: truong
 * Date: 18/10/18
 * Time: 5:10 PM
 */
class SupplyUserInfoService {
    public static function generateToken($length = 40) {
        return hash_hmac('sha256', str_random($length), config('app.key'));
    }

    public static function sendMailToDeactivatedUser(SupplyUserInfo $user) {
        $token          = self::generateToken();
        $email          = $user->login_id;

        $user->token    = $token;
        $user->token_expire = Carbon::now()->addDay();
        $user->save();
        //send mail
        self::sendEmail($email,$token);
    }

    public static function registrationUser($user,$isLogin = true){
        $token = self::generateToken();
        $user  = SupplyUserInfo::create([
            'login_id'      => $user['login_id'],
            'password'      => Hash::make($user['password']),
            'last_name'     => $user['last_name'],
            'first_name'    => $user['first_name'],
            'token'         => $token,
            'token_expire'  => Carbon::now()->addDay(),
            'status'        => 0,
            'auth_fail_num' => 0,
            'del_flg'       => 0,
        ]);

        // send email registration
        self::sendEmail($user->login_id,$user->token);

        if($isLogin)
            Auth::login($user);

        return $user;
    }

    public static function updateCompanyInfo($companyId, $updateData)
    {
        DB::beginTransaction();
        try {
            // create case
            if (empty($companyId)) {
                $maxJobs   = DefaultService::getCodeMstByGroup('max_job');
                $maxJobs   = ($maxJobs[0]['value'])?$maxJobs[0]['value']:0;
                if($maxJobs > 0)
                    $updateData['max_job_num'] = $maxJobs;

                $data = CompanyInfo::create($updateData);
                $update = SupplyUserInfo::where('id', Auth::user()->id)->update(['company_id' => $data->company_id]);
                // insert otp
                $code = DefaultService::makeOtpCode();
                $insertOtp = OtpCodes::create([
                    'company_id'        => $data->company_id,
                    'code'              => $code,
                    'expire_dt'         =>  Carbon::now()->addDay(SupplyUserInfo::EXPIRE_DAYS),
                    'generation_num'    => 1,
                    'status'            => 0,
                    'created_id'        => Auth::id(),
                ]);

            }else{//update case
                $data = CompanyInfo::where('company_id', $companyId)->update($updateData);
            }
            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollback();
            return false;
        }
    }

    public static function sendEmail($email,$token){
        EmailService::sendBySes(
            '【ナナコネ】メールアドレスの確認をお願いします',
            $email,
            'email.supply_activate',
            ['token' => $token]
        );
    }

    /**
     * function check available otp code by loged in user
     * @return array
     */
    public static function getOtpCodeByLoginUser(){
        $results = [
            'available' => false,
            'generation_num' => 0
        ];

        $user = Auth::user();
        if($user && $user->companyInfo && $user->companyInfo->otpCodes){
            if($user->companyInfo->otpCodes->status != OtpCodes::ACTIVATED_STATUS)
                $results['available'] = true;
            $results['generation_num'] = $user->companyInfo->otpCodes->generation_num;
        }

        return $results;
    }

    /**
     * @param $code
     * @return bool
     */
    public static function otpActiveCode($code){
        if(strlen((string)$code) < 8 )
            return false;

       // DB::beginTransaction();
        try{
            $otp = OtpCodes::getOtpByActiveCode($code);
            if($otp){
                $otp->status        = OtpCodes::ACTIVATED_STATUS;
                $updated = $otp->save();
                if($updated != true){
                    DB::rollBack();
                    return false;
                }

                $company = CompanyInfo::find($otp->company_id);
                if($company)
                    $company->status = OtpCodes::ACTIVATED_STATUS;

                if($company && $company->save() == true){
                    DB::commit();
                    return true;
                }

                DB::rollBack();
                return false;

            }
        }catch (\Exception $e){
            DB::rollBack();
            return false;
        }

    }

    /**
     * function reset otp code
     * @return bool
     */
    public static function userResetOtpCode(){
        try{
            if(!Auth::user() || Auth::user()->company_generation_num != 1)
                return false;
            $otp = OtpCodes::where('company_id',Auth::user()->company_id)->first();
            $code = DefaultService::makeOtpCode();
            $otp->code              = $code;
            $otp->status            = 0;
            $otp->generation_num    = $otp->generation_num + 1;
            $otp->expire_dt         = Carbon::now()->addDay(SupplyUserInfo::EXPIRE_DAYS);
            return $otp->save();
        }catch (\Exception $e){

        }

        return false;
    }

    /**
     * @param null $email
     * @return bool
     */
    public static function resetPassword($email = null){
        try{
            if(!$email)
                return false;
            $user = SupplyUserInfo::getUserInfoByLoginId($email);
            $user->change_pass_dt = Carbon::now()->addDay(1)->format('Y-m-d H:i:s');
            $user->save();
            $date = Carbon::now()->format('YmdHis');
            $encryptString = [
                'encrypt_key'       => md5($date.md5($user->login_id.$user->created_at)),
                'change_pass_dt'    => $user->change_pass_dt,
                'date'              => $date,
                'id'                => $user->id,
            ];
            $encryptString = Json::encode($encryptString);
            $encryptString = Crypt::encryptString($encryptString);
            EmailService::sendBySes(
                'supply reset password : '.$user->login_id,
                $user->login_id,
                'email.supply_reset_pass',
                [
                    'token' => $encryptString,
                    'loginId' => $user->login_id
                ]
            );
            return true;
        }catch (\Exception $e){

        }
        return false;
    }

    /**
     * get user
     * @param $encrypt
     * @return null
     */
    public static function getUserByEncrypt($encrypt){
        try{
            $data           = Crypt::decryptString($encrypt);
            $data           = json_decode($data, true);
            $date           = $data['date'];
            $changePassdt   = Carbon::now()->format('Y-m-d H:i:s');
            $user = SupplyUserInfo::select()->where([
                ['id',$data['id']],
                ['change_pass_dt','>=',$changePassdt]
            ])->first();

            if($data['encrypt_key'] == md5($date.md5($user->login_id.$user->created_at)) && $user->change_pass_dt == $data['change_pass_dt']){
//                $user->change_pass_dt = null;
//                $user->save();
               return $user;
            }

        }catch (\Exception $e){

        }
        return null;
    }

    /**
     * @param null $password
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public static function passwordMatch($password = null){
        //if( $password == null || !preg_match('@[A-Z]@', $password) || !preg_match('@[a-z]@', $password) || !preg_match('@[0-9]@', $password ))
        if( $password == null || !preg_match('@[a-z]@', $password) || !preg_match('@[0-9]@', $password ))
            return trans('supply.register.pass_charter');

        //$blackList = ['12345678', 'password' ,'abcdefgh' ];
        //if($password && in_array($password,$blackList))
        //   return trans('supply.register.pass_black_list');

        return '';
    }

}
