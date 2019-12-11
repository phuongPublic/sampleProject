<?php

namespace App\Http\Requests\Site;

use App\Services\SupplyUserInfoService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class ChangePassword extends FormRequest
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
                'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
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
            'password.required'  => trans('supply.register.pass_required'),
            'password.max'  => trans('supply.register.pass_string'),
            'password.min'  => trans('supply.register.pass_string'),
            'password.required_with'  => trans('supply.register.pass_confirm_required'),
            'password.same'  => trans('supply.register.pass_confirm_same'),
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
                    $data       = request()->all();
                    $parameters = Route::current()->parameters();
                    if(isset($parameters) && isset($parameters['key'])){
                        $user = SupplyUserInfoService::getUserByEncrypt($parameters['key']);
                        if(!$user)
                            $validator->errors()->add('password', __('not valid link '));
                    }else{
                        $user = Auth::user();
                        $check = Hash::check($data['password_old'], $user->password);
                        if(!$check){
                            $validator->errors()->add('password', __('validation.login.wrong_password'));
                        }
                    }

                    if(!$validator->errors()->has('password')){
                        $message = SupplyUserInfoService::passwordMatch($data['password']);
                        if(strlen($message) > 0)
                            $validator->errors()->add('password', $message);
                    }
                }
            }
        );
    }
}
