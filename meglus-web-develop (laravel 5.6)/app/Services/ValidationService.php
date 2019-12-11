<?php
namespace App\Services;
use Illuminate\Support\Facades\Validator;

/**
 * Created by PhpStorm.
 * User: truong
 * Date: 27/11/18
 * Time: 5:10 PM
 */
class ValidationService {

    /**
     * Validate for API
     * @param $request_data
     * @param $rules
     * @param $response
     * @param $message
     * @return array
     */
    public static function validateForApi($request_data, $rules, $response, $message = []) {
        $validator = Validator::make($request_data, $rules, $message);

        $errors_for_return = [];
        if ($validator->fails()) {
            $response['status_code'] = 422;

            foreach ($validator->errors()->getMessages() as $errors) {
                foreach ($errors as $error) {
                    $errors_for_return[] = $error;
                }
            }

            $response['errors'] = $errors_for_return;
            return $response;
        }

        return [];
    }

    public static function validateRuleForUpdateUser() {
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
            'name' => 'required|max:50|regex:/^[a-zA-Z0-9 ]{0,}$/i',
            'age' => 'required|numeric|min:1',
            //'nationality_cd' => 'required|in:' . implode(',', $country),
            'gender' => 'required|in:0,1',
            'home_nearest_station' => 'required|exists:stations,station_cd',
            'home_nearest_station_move_time' => 'required|numeric|min:0',
            'school_nearest_station' => 'required|exists:stations,station_cd',
            'school_nearest_station_move_time' => 'required|numeric|min:0',
            'post_cd' => 'numeric|digits:7',
            'prefecture' => 'exists:prefectures,id|required_with:city1,city2',
            'city1' => 'required_with:prefecture,city2',
            'city2' => 'required_with:city1,prefecture',
            'detail_address' => 'max:255',
            'tel' => 'regex:/^[\+]*[0-9]{1,15}$/i',
            'mail' => 'email|max:255',
            'residence_status_cd' => 'array|in:' . implode(',', $residence),
            'japanese_level' => 'in:' . implode(',', $japanese_level),
            'work_day' => 'array|in:0,1,2,3,4,5,6',
            'work_start_time' => 'date_format:H:i:s',
            'work_end_time' => 'date_format:H:i:s',
            'important1_cd' => 'nullable|in:' . implode(',', $important_thing),
            'important2_cd' => 'nullable|in:' . implode(',', $important_thing),
            'important3_cd' => 'nullable|in:' . implode(',', $important_thing),
            'profile' => 'mimes:jpeg,jpg,png,gif|max:10240',
//            'work_experiences' => 'array|max:3|in:' . implode(',', $job_category),
        ];
    }

    public static function validateRuleForRegisterDevice() {
        return [
            'device_token' => 'required|max:255',
            'registration_token' => 'required|max:255',
            'os' => 'required|in:ios,android,other',
            'os_version' => 'required|max:10',
            'app_version' => 'required|max:10',
        ];
    }

    public static function validateRuleForSubmitCelebrationMoney() {
        return [
            'job_id' => 'required',
            'bank_cd' => 'required',
            'bank_name' => 'required',
            'bank_branch_cd' => 'required',
            'bank_branch_name' => 'required',
            'bank_account_type' => 'required',
            'bank_account_name' => 'required|regex:/^[a-zA-Z0-9 ]{0,}$/i',
            'bank_account_num' => 'required|numeric',
            'first_work_day' => 'required|date_format:Ymd',
            'questionnaire_score' => 'required|in:1,2,3,4,5',
            'questionnaire_text' => 'required',
        ];
    }

    public static function validateRuleForUserProfileWhenApply() {
        return [
            'name' => 'required',
            'gender' => 'required',
            'home_nearest_station' => 'required',
            'home_nearest_station_move_time' => 'required',
            'post_cd' => 'required',
            'prefecture' => 'required',
            'city1' => 'required',
            'city2' => 'required',
            'detail_address' => 'required',
            'tel' => 'required',
            'residences' => 'required',
            'japanese_level' => 'required',
            'work_days' => 'required',
            'work_start_time' => 'required',
            'work_end_time' => 'required',
        ];
    }

    public static function validateMessageForUserProfileWhenApply() {
        return [
            'required' => 'errorApply_:attribute_required'
        ];
    }
}
