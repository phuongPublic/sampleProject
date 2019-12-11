<?php
$required_fix_str = 'を入力してください。';
$numeric_str = 'を半角数字で入力してください。';
$input_en_str = 'を半角英数で入力してください。';
$input_hankaku_str = 'を半角で入力してください。';
return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => ':attribute_must_be_after_specific_date',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => ':attribute_must_be_an_array',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => ':attribute_invalid_format',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => ':attribute_invalid_digits',
    'digits_between'       => ':attribute_digits_between',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute_mail_format',
    'exists'               => ':attribute_not_in_valid_values',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'gt'                   => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file'    => 'The :attribute must be greater than :value kilobytes.',
        'string'  => 'The :attribute must be greater than :value characters.',
        'array'   => 'The :attribute must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => ':attribute_must_be_greater_than_min',
        'file'    => ':attribute_must_be_greater_than_min',
        'string'  => ':attribute_must_be_greater_than_min',
        'array'   => ':attribute_must_be_greater_than_min',
    ],
    'image'                => 'The :attribute must be an image.',
    'in'                   => ':attribute_not_in_valid_values',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'lt'                   => [
        'numeric' => 'The :attribute must be less than :value.',
        'file'    => 'The :attribute must be less than :value kilobytes.',
        'string'  => 'The :attribute must be less than :value characters.',
        'array'   => 'The :attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file'    => 'The :attribute must be less than or equal :value kilobytes.',
        'string'  => 'The :attribute must be less than or equal :value characters.',
        'array'   => 'The :attribute must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => ':attribute_cannot_be_greater_than_max',
        'file'    => ':attribute_cannot_be_greater_than_max',
        'string'  => ':attribute_cannot_be_greater_than_max',
        'array'   => ':attribute_cannot_be_greater_than_max',
    ],
    'mimes'                => ':attribute_invalid_mimes',
    'mimetypes'            => ':attribute_invalid_mimetypes',
    'min'                  => [
        'numeric' => ':attribute_cannot_be_less_than_min',
        'file'    => ':attribute_cannot_be_less_than_min',
        'string'  => ':attribute_cannot_be_less_than_min',
        'array'   => ':attribute_cannot_be_less_than_min',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'not_regex'            => 'The :attribute format is invalid.',
    'numeric'              => ':attribute_numeric',
    'present'              => 'The :attribute field must be present.',
    'regex'                => ':attribute_format_invalid',
    'required'             => ':attribute_required',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => ':attribute_required_with',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'facebook_id' => 'facebook_id',
        'nationality_cd' => 'nationality_cd',
        'home_nearest_station' => 'home_nearest_station',
        'home_nearest_station_move_time' => 'home_nearest_station_move_time',
        'school_nearest_station' => 'school_nearest_station',
        'school_nearest_station_move_time' => 'school_nearest_station_move_time',
        'post_cd' => 'post_cd',
        'detail_address' => 'detail_address',
        'residence_status_cd' => 'residence_status_cd',
        'japanese_level' => 'japanese_level',
        'work_day' => 'work_day',
        'work_start_time' => 'work_start_time',
        'work_end_time' => 'work_end_time',
        'important1_cd' => 'important1_cd',
        'important2_cd' => 'important2_cd',
        'important3_cd' => 'important3_cd',
        'work_experience1_category_cd' => 'work_experience1_category_cd',
        'work_experience1_discription_cd' => 'work_experience1_discription_cd',
        'work_experience2_category_cd' => 'work_experience2_category_cd',
        'work_experience2_discription_cd' => 'work_experience2_discription_cd',
        'work_experience3_category_cd' => 'work_experience3_category_cd',
        'work_experience3_discription_cd' => 'work_experience3_discription_cd',
        'device_token' => 'device_token',
        'registration_token' => 'registration_token',
        'bank_cd' => 'bank_cd',
        'bank_name' => 'bank_name',
        'bank_branch_cd' => 'bank_branch_cd',
        'bank_branch_name' => 'bank_branch_name',
        'bank_account_type' => 'bank_account_type',
        'bank_account_name' => 'bank_account_name',
        'first_work_day' => 'first_work_day',
        'questionnaire_score' => 'questionnaire_score',
        'questionnaire_text' => 'questionnaire_text',
        'work_days' => 'work_days',
        'bank_account_num' => 'bank_account_num',
    ],

    'login' => [
        'wrong_email' => 'メールアドレスが間違っています。',
        'wrong_password' => 'パスワードが間違っています。',
        'not_valid_account' => '無効なアカウントです。',
        'not_valid_token' => '無効なトークです。',
    ],

    'demand' => [
        'name_required' => '氏名'.$required_fix_str,
        'name_max' => '氏名は255文字まで入力してください。',
        'birth_day_required' => '誕生日'.$required_fix_str,
        'nationality_cd_required' => '国籍'.$required_fix_str,
        'home_nearest_station_required' => '自宅最寄り駅'.$required_fix_str,
        'home_nearest_station_move_time_required' => '自宅最寄り駅からの徒歩時間'.$required_fix_str,
        'school_nearest_station_required' => '学校最寄り駅'.$required_fix_str,
        'school_nearest_station_move_time_required' => '学校最寄り駅からの徒歩時間'.$required_fix_str,
        'prefecture_required' => '都道府県'.$required_fix_str,
        'city1_required' => '市区町村1'.$required_fix_str,
        'city2_required' => '市区町村2'.$required_fix_str,
        'detail_address_required' => '丁目・番地'.$required_fix_str,
        'tel_required' => '電話番号'.$required_fix_str,
        'days_required' => '氏名'.$required_fix_str,
        'japanese_level_required' => '日本語能力'.$required_fix_str,
        'important1_cd_required' => '職場環境で大事なこと①'.$required_fix_str,
        'important2_cd_required' => '職場環境で大事なこと②'.$required_fix_str,
        'important3_cd_required' => '職場環境で大事なこと③'.$required_fix_str,
        'work_start_time_required' => '勤務時間From'.$required_fix_str,
        'work_end_time_required' => '勤務時間To'.$required_fix_str,
        'work_start_time_format' => '勤務時間Fromを正しく入力してください。 ',
        'work_end_time_format' => '勤務時間Toを正しく入力してください。 ',
        'work_end_time_after' => '勤務時間帯の終了時間が開始時間の後に設定してください。 ',
        'residences_required' => '在留資格'.$required_fix_str,
    ],
    'job' => [
        'workplace_post_cd_length' => '郵便番号が存在しません。',

        'workplace_name_required' => '会社名を入力してください。',
        'workplace_name_max' => '会社名を20文字まで入力してください。',

        'workplace_name_en_required' => '会社名（半角英数）を入力してください。',
        'workplace_name_en_max' => '会社名（半角英数）を20文字まで入力してください。',
        'workplace_name_en_format' => 'English char input',
        'workplace_post_cd_required' => '業種を入力してください。',

        'workplace_prefecture_required' => 'workplace_prefecture_required',
        'workplace_city1_required' => 'workplace_city1_required',
        'workplace_city2_required' => 'workplace_city2_required',

        'workplace_address_required' => 'workplace_address_required',

        'workplace_nearest_station_name_required' => 'workplace_nearest_station_name_required',
        'workplace_nearest_station_name_invalid' => 'workplace_nearest_station_name_invalid',

        'workplace_nearest_station_move_type_required' => 'workplace_nearest_station_move_type_required',
        'workplace_nearest_station_move_time_required' => 'workplace_nearest_station_move_time_required',

        'interview_post_cd_required' => 'パラメータ「郵便番号」の桁数が不正です。',
        'interview_prefecture_required' => 'interview_prefecture_required',
        'interview_city1_required' => 'interview_city1_required',
        'interview_city2_required' => 'interview_city2_required',

        'interview_detail_address_required' => 'interview_detail_address_required',

        'interview_nearest_station_name_required' => 'interview_nearest_station_name_required',
        'interview_nearest_station_name_invalid' => 'interview_nearest_station_name_invalid',

        'job_category_cd_required' => 'を入力してください。',
        'job_discription_cd_required' => 'job_discription_cd_required',

        'min_salary_required' => 'min_salary_required',
        'min_salary_min_value' => 'min_salary_min_value_%d',
        'max_salary_required' => 'max_salary_required',
        'min_max'             => 'min_max',

        'job_time_day_1_required' => 'job_time_day_1_required',
        'job_time_day_2_required' => 'job_time_day_2_required',
        'job_time_day_3_required' => 'job_time_day_3_required',

        'unit_time_start_1_required' => 'unit_time_start_1_required',
        'unit_time_start_2_required' => 'unit_time_start_2_required',
        'unit_time_start_3_required' => 'unit_time_start_3_required',

        'unit_time_end_1_required'  => 'unit_time_end_1_required',
        'unit_time_end_2_required'  => 'unit_time_end_2_required',
        'unit_time_end_3_required'  => 'unit_time_end_3_required',
        'time_start_end'            => 'time_start_end',
        'unit_time_start_1_format'          => 'unit_time_start_1_format',
        'unit_time_end_1_format'            => 'unit_time_end_1_format',
        'unit_time_start_2_format'          => 'unit_time_start_2_format',
        'unit_time_end_2_format'            => 'unit_time_end_2_format',
        'unit_time_start_3_format'          => 'unit_time_start_3_format',
        'unit_time_end_3_format'            => 'unit_time_end_3_format',
        'time_start_end_2'                    => 'time_start_end_2',
        'time_start_end_3'                    => 'time_start_end_3',

        'japanese_level_required' => 'japanese_level_required',
        'important1_cd_required' => 'important1_cd_required',
        'important2_cd_required' => 'important2_cd_required',
        'important3_cd_required' => 'important3_cd_required',
        'important_duplicate' => 'important_duplicate',
        'workplace_building_name_en_format' => 'workplace_building_name_en_format',
        'interview_building_name_en' => 'interview_building_name_en',

    ],
    'mypage' => [
        'not_demand_user' => 'not_demand_user。',
    ],
    'applyPopup' => [
        'interview_date_required' => '面接日'.$required_fix_str,
        'interview_date_is_past' => '過去日時を入力できません。',
        'interview_date_duplicate' => '面接候補日が重複しています。',
        'interview_date_duplicate_1' => '面接候補日①と②が重複しています。',
        'interview_date_duplicate_2' => '面接候補日②と③が重複しています。',
        'interview_date_duplicate_3' => '面接候補日①と③が重複しています。',
        'interview_time_required' => '面接時間'.$required_fix_str,
        'first_day_date_required' => '初勤務日'.$required_fix_str,
        'first_day_time_required' => '初勤務時間'.$required_fix_str,
        'interview_date_1_required' => '面接候補日①'.$required_fix_str,
        'interview_date_2_required' => '面接候補日②'.$required_fix_str,
        'interview_date_3_required' => '面接候補日③'.$required_fix_str,
        'interview_time_1_required' => '時間①'.$required_fix_str,
        'interview_time_2_required' => '時間②'.$required_fix_str,
        'interview_time_3_required' => '時間③'.$required_fix_str,
    ],
    'jobCategory' => [
        'name_required' => '名前は必須フィールドです',
        'name_max' => '名前フィールドに文字が多すぎます',
    ],

];
