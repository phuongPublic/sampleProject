<?php

namespace App\Http\Requests\Api;

use App\Model\JobCategoryMst;
use App\Services\DefaultService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;

class RegisterDevice extends FormRequest
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
        return [
            'device_token' => 'required|max:255',
            'registration_token' => 'required|max:255',
            'os' => 'required|in:ios,android,other',
            'os_version' => 'required|max:10',
            'app_version' => 'required|max:10',
        ];
    }
}
