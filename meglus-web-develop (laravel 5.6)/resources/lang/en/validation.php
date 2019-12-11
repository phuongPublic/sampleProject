<?php

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
    'regex'                => 'The :attribute format is invalid.',
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
        'work_days' => 'work_days',
        'bank_account_num' => 'bank_account_num',
    ],

    'login' => [
        'wrong_email' => 'メールアドレスが間違っています。',
        'wrong_password' => 'パスワードが間違っています。',
        'not_valid_account' => '無効なアカウントです。',
        'not_valid_token' => '無効なトークです。',
    ],
    'job' => [
        'workplace_post_cd_length' => 'パラメータ「郵便番号」の桁数が不正です。',
    ]

];
