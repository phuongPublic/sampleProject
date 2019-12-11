<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DemandRequest extends FormRequest
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
//            dd(request()->all());
//            dd(request()->all());
            $rules = [
                'name'                                  => 'required|max:255',
                'birth_day'                             => 'required|date',
                'nationality_cd'                        => 'required',
                'home_nearest_station'                  => 'required',
                'home_nearest_station_move_time'        => 'required',
                'school_nearest_station'                  => 'required',
                'school_nearest_station_move_time'        => 'required',
                'prefecture'        => 'required',
                'city1'        => 'required',
                'city2'        => 'required',
                'detail_address'        => 'required',
                'tel'        => 'required|numeric',
                'days'        => 'required',
                'japanese_level'        => 'required',
//                'important1_cd'        => 'required',
//                'important2_cd'        => 'required',
//                'important3_cd'        => 'required',
                'work_start_time'        => 'required|date_format:H:i',
                'work_end_time'        => 'required|date_format:H:i|after:work_start_time',
                'residences'        => 'required',
            ];
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
            'name.required' => __('validation.demand.name_required'),
            'name.max' => __('validation.demand.name_max'),
            'birth_day.required' => __('validation.demand.birth_day_required'),
            'nationality_cd.required' => __('validation.demand.nationality_cd_required'),
            'home_nearest_station.required' => __('validation.demand.home_nearest_station_required'),
            'home_nearest_station_move_time.required' => __('validation.demand.home_nearest_station_move_time_required'),
            'school_nearest_station.required' => __('validation.demand.school_nearest_station_required'),
            'school_nearest_station_move_time.required' => __('validation.demand.school_nearest_station_move_time_required'),
            'prefecture.required' => __('validation.demand.prefecture_required'),
            'city1.required' => __('validation.demand.city1_required'),
            'city2.required' => __('validation.demand.city2_required'),
            'detail_address.required' => __('validation.demand.detail_address_required'),
            'tel.required' => __('validation.demand.tel_required'),
            'days.required' => __('validation.demand.days_required'),
            'japanese_level.required' => __('validation.demand.japanese_level_required'),
//            'important1_cd.required' => __('validation.demand.important1_cd_required'),
//            'important2_cd.required' => __('validation.demand.important2_cd_required'),
//            'important3_cd.required' => __('validation.demand.important3_cd_required'),
            'work_start_time.required' => __('validation.demand.work_start_time_required'),
            'work_end_time.required' => __('validation.demand.work_end_time_required'),
            'work_start_time.date_format' => __('validation.demand.work_start_time_format'),
            'work_end_time.date_format' => __('validation.demand.work_end_time_format'),
            'work_end_time.after' => __('validation.demand.work_end_time_after'),
            'residences.required' => __('validation.demand.residences_required'),
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
        $response['status'] = 200;
        $response['messages'] = [];
        foreach ($validator->errors()->toArray() as $key => $item ){
            if(in_array($key,['prefecture','city1','city2']))
                $key = 'workplace_'.$key;
            $response['messages'][$key] = $item[0];
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
            $validator->after(function ($validator) {
                if (!$validator->errors()->has('important1_cd') && !$validator->errors()->has('important2_cd') && !$validator->errors()->has('important3_cd')) {
                    $request = request();
                    $tmp = [$request->important1_cd, $request->important2_cd, $request->important3_cd];
                    $duplicates = $this->array_duplicates($tmp);
                    if (count($duplicates) > 0) {
                        if (in_array($request->important1_cd, $duplicates)) {
                            $validator->errors()->add('important1_cd', __('supply.job.important_duplicate'));
                        } elseif (in_array($request->important2_cd, $duplicates)) {
                            $validator->errors()->add('important2_cd', __('supply.job.important_duplicate'));
                        } elseif (in_array($request->important3_cd, $duplicates)) {
                            $validator->errors()->add('important3_cd', __('supply.job.important_duplicate'));
                        }
                    }
                }
            });
        }
    }

    /**
     * Get duplicate value in array
     *
     * @param $array
     * @return array
     */
    private function array_duplicates(array $array)
    {
        $dulicates = array_diff_assoc($array, array_unique($array));
        foreach ($dulicates as $key => $item){
            if(!(int)$item > 0)
                unset($dulicates[$key]);
        }

        return $dulicates;
    }

}
