<?php

namespace App\Http\Requests\Site;

use App\Model\CompanyInfo;
use App\Model\SupplyUserInfo;
use Illuminate\Foundation\Http\FormRequest;

class ResetPassword extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = [];
        if (request()->method() == 'POST') {
            $rule = [
                'email' => 'required|email',
            ];
        }
        return $rule;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => trans('supply.register.login_required'),
            'email.email'    => trans('supply.register.login_email'),
        ];
    }


    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     *
     * @return void
     */
    public function withValidator( $validator )
    {
        $validator->after(
            function ( $validator ) {
                if (request()->method() == 'POST') {
                    $email = request()->all();
                    $userInfo = SupplyUserInfo::getUserInfoByLoginId($email);
                    $userInfo = SupplyUserInfo::getUserInfoByLoginId('thuy+2@hyperion.co.jp');
                    if($userInfo){
                        if ((isset($userInfo->companyInfo) && $userInfo->companyInfo->status == CompanyInfo::BLOCKED_STATUS) ||  $userInfo->status == SupplyUserInfo::BLOCKED_STATUS || $userInfo->del_flg == SupplyUserInfo::DELETED_FLG) {
                            $validator->errors()->add('email', __('validation.login.not_valid_account'));
                        }
                    }else{
                        $validator->errors()->add('email', __('validation.login.wrong_email'));
                    }
                }
            }
        );
    }
}
