<?php

namespace App\Http\Requests\Api;

use App\Model\JobCategoryMst;
use App\Services\DefaultService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;

class SaveProfile extends FormRequest
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
        $country = DefaultService::getCodeMstByGroup('country');
        $country = array_pluck($country, 'value');

        $residence = DefaultService::getCodeMstByGroup('residence_qualification');
        $residence = array_pluck($residence, 'value');

        $japanese_level = DefaultService::getCodeMstByGroup('japanese_level');
        $japanese_level = array_pluck($japanese_level, 'value');

        $important_thing = DefaultService::getCodeMstByGroup('important_thing');
        $important_thing = array_pluck($important_thing, 'value');

//        $job_category = JobCategoryMst::get_parent_category();
//        $job_category = array_pluck($job_category, 'id');

        return [
            'name' => 'required|max:50',
            'age' => 'required|numeric|min:1',
            //'nationality_cd' => 'required|in:' . implode(',', $country),
            'gender' => 'required|in:0,1',
            'home_nearest_station' => 'required|exists:stations,station_cd',
            'home_nearest_station_move_time' => 'required|gte:0',
            'school_nearest_station' => 'required|exists:stations,station_cd',
            'school_nearest_station_move_time' => 'required|gte:0',
            'post_cd' => 'numeric|digits:7',
            'prefecture' => 'exists:prefectures,id|required_with:city1,city2',
            'city1' => 'required_with:prefecture,city2',
            'city2' => 'required_with:city1,prefecture',
            'detail_address' => 'max:255',
            'tel' => 'numeric|digits_between:1,15',
            'mail' => 'email|max:255',
            'residence_status_cd' => 'array|in:' . implode(',', $residence),
            'japanese_level' => 'in:' . implode(',', $japanese_level),
            'work_day' => 'array|in:0,1,2,3,4,5,6',
            'work_start_time' => 'date_format:Y-m-d H:i:s',
            'work_end_time' => 'date_format:Y-m-d H:i:s|after:work_start_time',
            'important1_cd' => 'in:' . implode(',', $important_thing),
            'important2_cd' => 'in:' . implode(',', $important_thing),
            'important3_cd' => 'in:' . implode(',', $important_thing),
            'profile' => 'mimes:jpeg,jpg,png,gif|max:1024',
//            'work_experiences' => 'array|max:3|in:' . implode(',', $job_category),
        ];
    }
}
