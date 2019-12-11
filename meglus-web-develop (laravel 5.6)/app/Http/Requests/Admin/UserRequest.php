<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [];
        if(request()->method() == 'POST'){
            if(request()->has('password')){
                $rules = [
                    'password' => 'required|confirmed|min:6',
                ];
            }

            if(request()->has(['first_name', 'last_name'])){
                $rules = [
                    'first_name' => 'max:255',
                    'last_name' => 'max:255',
                ];
            }
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.required' => __('Password is required'),
            'password.confirmed' => __('Not match password'),
            'password.min' => __('Password min 6 characters'),
            'first_name.max' => __('First name max 255 characters'),
            'last_name.max' => __('Last name max 255 characters'),
        ];
    }

}
