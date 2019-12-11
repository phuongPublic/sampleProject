<?php

namespace App\Http\Requests\Site;

use App\Services\ApplyService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ApplyPopupRequest extends FormRequest
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
        if(request()->method() == 'POST'){
            $rules = [];
            $applicant = ApplyService::findById(request()->id)->toArray();
            if(in_array(request()->action, ['send_interview_info','accept_interview_date']) || ($applicant['application_method'] == 0 && request()->action == 'apply')){
                $rules = [
                    'interview_date' => 'required',
                    'interview_time' => 'required'
                ];
            }elseif (in_array(request()->action, ['set_acceptance','send_first_day_info']) ){
                $rules = [
                    'first_day_date' => 'required',
                    'first_day_time' => 'required'
                ];
            }elseif (in_array(request()->action, ['send_interview_date','reject_interview_date','request_change_interview_date']) || ($applicant['application_method'] == 1 && request()->action == 'apply')){
                $rules = [
                    'interview_date_1' => 'required',
                    'interview_date_2' => 'required',
                    'interview_date_3' => 'required',
                    'interview_time_1' => 'required',
                    'interview_time_2' => 'required',
                    'interview_time_3' => 'required',
                ];
            }
            return $rules;
        }
        return [];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'interview_date.required' => __('validation.applyPopup.interview_date_required'),
            'interview_time.required' => __('validation.applyPopup.interview_time_required'),
            'first_day_date.required' => __('validation.applyPopup.first_day_date_required'),
            'first_day_time.required' => __('validation.applyPopup.first_day_time_required'),
            'interview_date_1.required' => __('validation.applyPopup.interview_date_1_required'),
            'interview_date_2.required' => __('validation.applyPopup.interview_date_2_required'),
            'interview_date_3.required' => __('validation.applyPopup.interview_date_3_required'),
            'interview_time_1.required' => __('validation.applyPopup.interview_time_1_required'),
            'interview_time_2.required' => __('validation.applyPopup.interview_time_2_required'),
            'interview_time_3.required' => __('validation.applyPopup.interview_time_3_required'),
        ];
    }

    /**
    * Handle a failed validation attempt.
    *
    * @param  \Illuminate\Contracts\Validation\Validator  $validator
    * @return void
    *
    * @throws \Illuminate\Validation\ValidationException
    */
    protected function failedValidation(Validator $validator) {
        $response['status'] = 400;
        $response['errors'] = [];
        foreach ($validator->errors()->toArray() as $key => $item ){
            $response['errors'][$key] = $item[0];
        }
        throw new HttpResponseException(response()->json($response, 200));
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if (request()->method() == 'POST') {
            $request = request();
            $validator->after(function ($validator) use ($request) {
                $applicant = ApplyService::findById($request->id)->toArray();
                if (in_array($request->action, ['send_interview_info', 'accept_interview_date']) || ($applicant['application_method'] == 0 && $request->action == 'apply')) {
                    if (!$validator->errors()->has('interview_date')) {
                        if (date('Y/m/d', strtotime(str_replace(' ','',$request->interview_date))) < date('Y/m/d')) {
                            $validator->errors()->add('interview_date', __('validation.applyPopup.interview_date_is_past'));
                        } elseif (date('Y/m/d', strtotime(str_replace(' ','',$request->interview_date))) == date('Y/m/d')) {
                            if (!$validator->errors()->has('interview_time')) {
                                if (date('H:i', strtotime(str_replace(' ','',$request->interview_time))) < date('H:i')) {
                                    $validator->errors()->add('interview_time', __('validation.applyPopup.interview_date_is_past'));
                                }
                            }
                        }
                    }
                } elseif (in_array($request->action, ['set_acceptance', 'send_first_day_info'])) {
                    if (!$validator->errors()->has('first_day_date')) {
                        if (date('Y/m/d', strtotime(str_replace(' ','',$request->first_day_date))) < date('Y/m/d')) {
                            $validator->errors()->add('first_day_date', __('validation.applyPopup.interview_date_is_past'));
                        } elseif (date('Y/m/d', strtotime(str_replace(' ','',$request->first_day_date))) == date('Y/m/d')) {
                            if (!$validator->errors()->has('first_day_time')) {
                                if (date('H:i', strtotime(str_replace(' ','',$request->first_day_time))) < date('H:i')) {
                                    $validator->errors()->add('first_day_time', __('validation.applyPopup.interview_date_is_past'));
                                }
                            }
                        }
                    }
                } elseif (in_array($request->action, ['send_interview_date', 'reject_interview_date', 'request_change_interview_date']) || ($applicant['application_method'] == 1 && $request->action == 'apply')) {
                    for ($index = 1; $index <= 3; $index++) {

                        if (!$validator->errors()->has('interview_date_'.$index)) {
                            if (date('Ymd', strtotime(str_replace(' ','',$request->{'interview_date_'.$index}))) < date('Ymd')) {
                                $validator->errors()->add('interview_date_'.$index, __('validation.applyPopup.interview_date_is_past'));
                            }elseif (date('Ymd', strtotime(str_replace(' ','',$request->{'interview_date_'.$index}))) == date('Ymd')) {
                                if (!$validator->errors()->has('interview_time_'.$index)) {
                                    if (date('H:i', strtotime(str_replace(' ','',$request->{'interview_time_'.$index}))) < date('H:i')) {
                                        $validator->errors()->add('interview_time_'.$index, __('validation.applyPopup.interview_date_is_past'));
                                    }
                                }
                            }
                        }
                    }


                    //validate date 1!=2!=3
                    if($validator->errors()->count() == 0){
                        $interview1 = date('YmdHi', strtotime(str_replace(' ','',$request->{'interview_date_1'}.' '.str_replace(' ','',$request->{'interview_time_1'}))));
                        $interview2 = date('YmdHi', strtotime(str_replace(' ','',$request->{'interview_date_2'}.' '.str_replace(' ','',$request->{'interview_time_2'}))));
                        $interview3 = date('YmdHi', strtotime(str_replace(' ','',$request->{'interview_date_3'}.' '.str_replace(' ','',$request->{'interview_time_3'}))));
                        if($interview1 == $interview2 && $interview2 == $interview3){
                            $validator->errors()->add('interview_date_1', __('validation.applyPopup.interview_date_duplicate'));
                        }elseif($interview1 == $interview2){
                            $validator->errors()->add('interview_date_1', __('validation.applyPopup.interview_date_duplicate_1'));
                        }elseif($interview2 == $interview3){
                            $validator->errors()->add('interview_date_2', __('validation.applyPopup.interview_date_duplicate_2'));
                        }elseif($interview3 == $interview1){
                            $validator->errors()->add('interview_date_1', __('validation.applyPopup.interview_date_duplicate_3'));
                        }
                    }
                }
            });
        }
    }

}
