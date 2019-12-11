<?php
$required_fix_str = 'を入力してください。';
$numeric_str = 'を半角数字で入力してください。';
$input_en_str = 'を半角英数で入力してください。';
$input_hankaku_str = 'を半角で入力してください。';
return [
    'common' => [
        'choose'            => '選択してください',
        'update_fail'       => '変更失敗しました。',
        'post_cd_required'  => '郵便' . $required_fix_str,
        'post_cd_digits'    => '郵便番号が存在しません。',
        'post_cd_numeric'   => '郵便' . $numeric_str,
        'update_success'    => '更新しました。',
        'created_success'   => '更新しました。',
        'created_job_success'   => '記事を掲載しました。',
        'edit_job_success'   => '記事を更新しました。',
        'system_error'      => 'システムエラーが発生します。',
        'title_mypage'      => 'マイページ',
        'title_apply'       => '応募者リスト',
        'link_to_my_page'   => 'マイページに戻る',
        'title_result'      => '成果報酬の確認',
    ],
    'header' => [
        'home' => 'ホーム',
        'profile' => '会社概要',
        'vision' => '理念・ビジョン',
        'contact' => 'お問い合わせ',
        'login' => '企業ログイン',
        'language' => '言語選択',
        'language_japanese' => '日本語（デフォルト）',
        'language_vietnamese' => 'ベトナム語',
        'language_english' => '英語',
        'language_hiragana' => 'ひらがな',
    ],
    'menu' => [
        'important_thing' => '仕事で大事なことマスター',
    ],
    'footer' => [
        'copyright' => 'Copyright © Meglus Inc. , All Rights Reserved.',
        'terms' => '利用規約',
        'privacy_policy' => 'プライバシーポリシー',
    ],
    'register' => [
        'switch_to_login' => 'すでにアカウントをお持ちの方は',
        'switch_to_login_link' => 'こちら',
        'title' => 'アカウント登録',
        'email' => 'メールアドレス',
        'confirm' => '（確認）',
        'first_name' => '名',
        'last_name' => '姓',
        'password' => 'パスワード',
        'terms' => '利用規約',
        'email_text' => '送信ボタンを押すことで、登録されたメールアドレスに認証メールが届きます。 <br> <span class="color-red">24時間以内に送信されたメールの認証をお願いいたします。</span>',
        'submit_btn' => '利用規約に同意して企業情報の入力に進む',
        'login_required' => 'メールアドレスを入力してください。',
        'login_email' => 'メールアドレスが不正です。 ',
        'login_unique' => 'すでに使われているメールアドレスです。 ',
        'login_confirm_required' => 'メールアドレス（確認）を入力してください。',
        'login_confirm_same' => 'メールアドレスが一致しません。',
        'last_name_required' => '姓を入力してください。',
        'first_name_required' => '名を入力してください。',
        'pass_required' => 'パスワードを入力してください。',
        'pass_string' => 'パスワードを8文字から32文字まで入力してください。',
        'pass_charter' => 'パスワードを1文字以上の英大文字と1文字以上の数字で入力してください。',
        'pass_black_list' => 'パスワードが推測しやすい為、再度設定してください。',
        'pass_confirm_required' => 'パスワード（確認）を入力してください。',
        'pass_confirm_same' => 'パスワードが一致しません。',

    ],
    'login' => [
        'title' => 'ログイン',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'switch_to_register' => 'アカウントをお持ちでない方は',
        'switch_to_register_link' => 'こちら',
    ],
    'job' => [
        'create' => '掲載記事の入力',
        'submit_btn' => '新規記事を掲載する',
        'find_address_btn' => '住所自動入力',
        'localtion' => '勤務先の入力',
        'workplace_name' => '勤務先名',
        'workplace_name_en' => '勤務先名（半角英数）',
        'work_localtion' => '勤務先住所の入力',
        'workplace_post_cd' => '郵便（半角数字・－なし）',
        'workplace_prefecture' => '都道府県',
        'workplace_city1' => '市区町村1',
        'workplace_city2' => '市区町村2',
        'workplace_address' => '丁目・番地（半角）',
        'workplace_building_name' => '建物名（任意）',
        'workplace_building_name_en' => '建物名（任意・半角英数）',
        'workplace_nearest_station_name' => '最寄り駅名',
        'workplace_nearest_station_move_type' => '最寄り駅からの移動時間',
        'workplace_nearest_station_move_type_option_0' => '徒歩',
        'workplace_nearest_station_move_type_option_1' => 'バス',
        'workplace_nearest_station_move_time' => '分',

        'location_interview' => '面接場所の入力',
        'interview_place_post_cd' => '郵便（半角数字・－なし）',
        'interview_prefecture' => '都道府県',
        'interview_city1' => '市区町村1',
        'interview_city2' => '市区町村2',
        'interview_detail_address' => '丁目・番地（半角）',
        'interview_building_name' => '建物名（任意）',
        'interview_building_name_en' => '建物名（任意・半角英数）',
        'interview_nearest_station_name' => '最寄り駅名',
        'interview_nearest_station_move_type' => '最寄り駅からの移動時間',
        'interview_nearest_station_move_type_option_0' => '徒歩',
        'interview_nearest_station_move_type_option_1' => 'バス',
        'interview_nearest_station_move_time' => '分',

        'job_detail' => '業務内容の入力',
        'job_category_cd' => '職種',
        'job_discription_cd' => '職務内容',
        'salary' => '時給（半角数字）',
        'unit' => '円',
        'unit_time_start' => '00:00',
        'unit_time_end' => '23:59',
        'job_time' => '勤務時間の入力',
        'job_time_detail' => '勤務時間帯①（必須）',
        'monday' => '月',
        'tuesday' => '火',
        'wednesday' => '水',
        'thursday' => '木',
        'friday' => '金',
        'saturday' => '土',
        'sunday' => '日',
        'job_time_detail_2' => '勤務時間帯② （任意）',
        'job_time_detail_3' => '勤務時間帯③ （任意）',
        'job_skill' => '役に立つスキル',
        'japanese_level' => '日本語能力',
        'job_skill_1' => '仕事経験①（任意）',
        'job_skill_2' => '仕事経験②（任意）',
        'job_skill_3' => '仕事経験③（任意）',
        'job_important' => '仕事で大事なこと',
        'job_important_1' => '仕事で大事なこと①',
        'job_important_2' => '仕事で大事なこと②',
        'job_important_3' => '仕事で大事なこと③',
        'address_null' => '郵便番号が存在しません。',
        'address_city1_null' => '郵便番号が存在しません。',
        'address_city2_null' => '郵便番号が存在しません。',
        'created_error' => 'job_created_error',
        'created_success' => '再発行しました。',
        'application_method' => '応募者への連絡方法の選択',
        'application_method_label_1' => '<p>電話のみ</p>高い日本語レベルを求める仕事にオススメです。',
        'application_method_label_2' => '<p>電話とメッセージ</p>よりたくさんの応募を期待できます。',

        'workplace_name_required' => '勤務先名' . $required_fix_str,
        'workplace_name_max' => '勤務先名' . '２０文字まで入力してください。',
        'workplace_name_en_required' => '勤務先名（半角英数）' . $required_fix_str,
        'workplace_name_en_max' => '勤務先名（半角英数）' . '２０文字まで入力してください。',
        'workplace_name_en_format' => '勤務先名（半角英数）'.$input_en_str,
        'workplace_post_cd_required' => '勤務先住所の郵便' . $required_fix_str,
        'workplace_prefecture_required' => '勤務先住所の都道府県' . $required_fix_str,
        'workplace_city1_required' => '勤務先住所の市区町村1' . $required_fix_str,
        'workplace_city2_required' => '勤務先住所の市区町村2' . $required_fix_str,
        'workplace_address_required' => '勤務先住所の丁目・番地' . $required_fix_str,
        'workplace_building_name_en_format' => '勤務先住所の建物名（任意・半角英数）'.$input_en_str,
        'workplace_nearest_station_cd_required' => '勤務先住所の最寄り駅名' . $required_fix_str,
        'workplace_nearest_station_move_time_required' => '勤務先住所の最寄り駅からの移動時間' . $required_fix_str,

        'interview_post_cd_required' => '面接場所の郵便' . $required_fix_str,
        'interview_prefecture_required' => '面接場所の都道府県' . $required_fix_str,
        'interview_city1_required' => '面接場所の市区町村1' . $required_fix_str,
        'interview_city2_required' => '面接場所の市区町村2' . $required_fix_str,
        'interview_detail_address_required' => '面接場所の丁目・番地' . $required_fix_str,
        'interview_building_name_en_format' => '面接場所の建物名（任意・半角英数）'.$input_en_str,
        'interview_nearest_station_cd_required' => '面接場所の最寄り駅名' . $required_fix_str,
        'interview_nearest_station_move_time_required' => '面接場所の最寄り駅からの移動時間' . $required_fix_str,

        'job_category_cd_required' => '職種' . $required_fix_str,
        'job_discription_cd_required' => '職務内容' . $required_fix_str,
        'min_salary_required' => '最低時給' . $required_fix_str,
        'max_salary_required' => '最高時給' . $required_fix_str,
        'min_salary_min_value' => '最低時給を%d以上に入力してください。',
        'max_salary_max_value' => '最高賃金を%d円以下に入力してください。',
        'min_max_salary' => '最高時給を最低時給より設定してください。',
        'min_salary' => '時給MIN',
        'max_salary' => '時給MAX',

        /* start 勤務時間帯① */
        // empty
        'job_time_day_1_required' => '勤務時間帯①' . $required_fix_str,
        'unit_time_start_1_required' => '勤務時間帯①の開始時間' . $required_fix_str,
        'unit_time_end_1_required' => '勤務時間帯①の終了時間' . $required_fix_str,

        // wrong time format
        'unit_time_start_1_format' => '勤務時間帯①の開始時間を正しく入力してください。',
        'unit_time_end_1_format' => '勤務時間帯①の終了時間を正しく入力してください。',

        // start time >= end time
        'time_start_end' => '勤務時間帯①の終了時間が開始時間の後に設定してください。',
        /* end 勤務時間帯① */

        /* start 勤務時間帯② */
        // empty
        'job_time_day_2_required' => '勤務時間帯②' . $required_fix_str,
        'unit_time_start_2_required' => '勤務時間帯②の開始時間' . $required_fix_str,
        'unit_time_end_2_required' => '勤務時間帯②の終了時間' . $required_fix_str,

        // wrong time format
        'unit_time_start_2_format' => '勤務時間帯②の開始時間を正しく入力してください。',
        'unit_time_end_2_format' => '勤務時間帯②の終了時間を正しく入力してください。',

        // start time >= end time
        'time_start_end_2' => '勤務時間帯②の終了時間が開始時間の後に設定してください。',
        /* end 勤務時間帯② */

        /* start 勤務時間帯③ */
        // empty
        'job_time_day_3_required' => '勤務時間帯③' . $required_fix_str,
        'unit_time_start_3_required' => '勤務時間帯③の開始時間' . $required_fix_str,
        'unit_time_end_3_required' => '勤務時間帯③の終了時間' . $required_fix_str,

        // wrong time format
        'unit_time_start_3_format' => '勤務時間帯③の開始時間を正しく入力してください。',
        'unit_time_end_3_format' => '勤務時間帯③の終了時間を正しく入力してください。',

        // start time >= end time
        'time_start_end_3' => '勤務時間帯③の終了時間が開始時間の後に設定してください。',
        /* end 勤務時間帯③ */

        'japanese_level_required' => '日本語能力' . $required_fix_str,
        'max_job_num' => '最大％d仕事までしか登録できません。',
        'access_block' => '記事が強制停止中です。',
    ],
    'company' => [
        'index' => '企業リスト',
        'title_screen' => '企業情報の入力',
        'company_name' => '会社名',
        'company_name_en' => '会社名（半角英数）',
        'job_category_cd' => '業種',
        'tel' => '電話（半角数字・－なし）',
        'post_cd' => '郵便（半角数字・－なし）',
        'prefecture' => '都道府県',
        'city1' => '市区町村1',
        'city2' => '市区町村2',
        'detail_address' => '丁目・番地（半角）',
        'building_name' => '建物名（任意）',
        'building_name_p_holder' => '建物名',
        'building_name_en' => '建物名（任意・半角英数）',
        'submit_btn' => '掲載記事の作成に進む',

        //error messages region
        'company_name_required' => '会社名' . $required_fix_str,
        'company_name_max' => '会社名を20文字まで' . $required_fix_str,
        'company_name_en_required' => '会社名（半角英数）' . $required_fix_str,
        'company_name_en_format' => '会社名（半角英数）' . $input_en_str,
        'job_category_cd_required' => '業種'. $required_fix_str,
        'job_category_cd_numeric' => '業種'. $numeric_str,
        'tel_required' => '電話'. $required_fix_str,
        'tel_numeric' => '電話'. $numeric_str,
        'tel_max' => '電話を15文字まで入力してください。',
        'prefecture_required' => '都道府県' . $required_fix_str,
        'city1_required' => '市区町村1' . $required_fix_str,
        'city2_required' => '市区町村2' . $required_fix_str,
        'detail_address_required' => '丁目・番地' . $required_fix_str,
        'detail_address_format' => '丁目・番地' . $input_hankaku_str,
        'building_name_en_format' => '建物名（任意・半角英数）' . $input_en_str,
        'update_success' => '企業情報が更新しました。',
        'expire' => 'コードの認証期限切れです',
        'company_expire_success' => '再発行しました。',
    ],
    'otp' => [
      'index' => '認証コード管理',
      'otp_empty' => '認証コード' . $required_fix_str,
      'otp_length' => '８桁の認証コードを入力してください。',
    ],
    'apply_popup_title' => [
        'apply' => '様に面接案内を送信します',
        'send_interview_info' => '様に面接案内を送信します',
        'accept_interview_date' => '様に面接案内を送信します',
        'send_first_day_info' => '様に初勤務日を送信します',
        'set_acceptance' => '様に初勤務日を送信します',
    ],
    'demand' => [
        'title_index'   => '求職者リスト',
        'title_view'    => '求職者詳細',
        'title_update'  => '求職者編集',
    ],
    'kpi' => [
        'title_index'   => 'KPI',
        'title_rate'   => '継続率',
        'title_sequence_trigger'   => 'シーケンス（トリガー）',
        'title_sequence'   => 'シーケンス（累積）',
        'title_jlpt'   => '日本語能力',
        'jlpt'   => '日本語能力',
        'title_important'   => '仕事で大事なこと',
        'job_type'          => '職種・職務内容',
        'medium_job_type'   => '職種・職務内容の平均時給',
        'title_station'   => '最寄り駅（勤務先）',
        'sequence' => 'シーケンス（トリガー）',
        'cumulative-sequence' => 'シーケンス（累積）',
        'account_register' => '新規登録アカウント数',
        'company_register' => '新規登録企業数',
        'account_register_job' => '新規記事掲載数（新規登録企業）',
        'supply_account_cumulative' => 'アカウント数（累積）',
        'company_account_cumulative' => '登録企業数（累積）',
        'new_jobs' => '新規記事掲載数（全体）',
        'active_jobs' => '掲載中の記事数',
        'stoped_jobs' => '停止中の記事数',
        'edited_jobs'=> '記事編集回数',
        'jobs_apply_by_phone' => '電話応募の記事数',
        'jobs_apply_by_phone_and_email' => '電話・メッセージ応募の記事数',
        'N1' => 'N1',
        'N2' => 'N2',
        'N3' => 'N3',
        'N4' => 'N4',
        'N5' => 'N5',
        'jobs_N1' => 'N1',
        'jobs_N2' => 'N2',
        'jobs_N3' => 'N3',
        'jobs_N4' => 'N4',
        'jobs_N5' => 'N5',
        'sequence_p01' => 'p01',
        'sequence_p02' => 'p02',
        'sequence_p03' => 'p03',
        'sequence_p04' => 'p04',
        'sequence_p05' => 'p05',
        'sequence_p06' => 'p06',
        'sequence_p07' => 'p07',
        'sequence_p08' => 'p08',
        'sequence_p09' => 'p09',
        'sequence_m01' => 'm01',
        'sequence_m02' => 'm02',
        'sequence_m03' => 'm03',
        'sequence_m04' => 'm04',
        'sequence_m05' => 'm05',
        'sequence_m06' => 'm06',
        'sequence_m07' => 'm07',
        'sequence_m08' => 'm08',
        'sequence_m09' => 'm09',
        'sequence_m10' => 'm10',
        'sequence_m11' => 'm11',
        'sequence_m12' => 'm12',
        'sequence_m13' => 'm13',
        'cumulative_sequence_p01' => 'p01',
        'cumulative_sequence_p02' => 'p02',
        'cumulative_sequence_p03' => 'p03',
        'cumulative_sequence_p04' => 'p04',
        'cumulative_sequence_p05' => 'p05',
        'cumulative_sequence_p06' => 'p06',
        'cumulative_sequence_p07' => 'p07',
        'cumulative_sequence_p08' => 'p08',
        'cumulative_sequence_p09' => 'p09',
        'cumulative_sequence_m01' => 'm01',
        'cumulative_sequence_m02' => 'm02',
        'cumulative_sequence_m03' => 'm03',
        'cumulative_sequence_m04' => 'm04',
        'cumulative_sequence_m05' => 'm05',
        'cumulative_sequence_m06' => 'm06',
        'cumulative_sequence_m07' => 'm07',
        'cumulative_sequence_m08' => 'm08',
        'cumulative_sequence_m09' => 'm09',
        'cumulative_sequence_m10' => 'm10',
        'cumulative_sequence_m11' => 'm11',
        'cumulative_sequence_m12' => 'm12',
        'cumulative_sequence_m13' => 'm13',
        'job_important_thing_cd_1' => 'シフト調整可能',
        'job_important_thing_cd_2' => '日払い可能',
        'job_important_thing_cd_3' => 'ベトナム人勤務中',
        'job_important_thing_cd_4' => 'ネパール人勤務中',
        'job_important_thing_cd_5' => '履歴書不要',
        'job_important_thing_cd_6' => '未経験OK',
        'job_important_thing_cd_7' => '日本語レベル求めない',
        'job_important_thing_cd_8' => '昇給有り',
        'job_important_thing_cd_9' => '正社員渡洋有り',
        'job_important_thing_cd_10' => '交通費支給',
        'job_important_thing_cd_11' => 'まかないあり',
        'job_important_thing_cd_12' => '中国人勤務中',
        'job_important_thing_cd_13' => '韓国人勤務中',
        'important_thing_cd_1' => 'シフト調整可能',
        'important_thing_cd_2' => '日払い可能',
        'important_thing_cd_3' => 'ベトナム人勤務中',
        'important_thing_cd_4' => 'ネパール人勤務中',
        'important_thing_cd_5' => '履歴書不要',
        'important_thing_cd_6' => '未経験OK',
        'important_thing_cd_7' => '日本語レベル求めない',
        'important_thing_cd_8' => '昇給有り',
        'important_thing_cd_9' => '正社員渡洋有り',
        'important_thing_cd_10' => '交通費支給',
        'important_thing_cd_11' => 'まかないあり',
        'important_thing_cd_12' => '中国人勤務中',
        'important_thing_cd_13' => '韓国人勤務中',

        'supply_can_change_working_day' => 'シフト調整可能',
        'supply_pay_per_day' => '日払い可能',
        'supply_vietnamese_working' => 'ベトナム人勤務中',
        'supply_nepal_working' => 'ネパール人勤務中',
        'supply_no_need_skill' => '履歴書不要',
        'supply_no_need_experience' => '未経験OK',
        'supply_no_need_japanese_level' => '日本語レベル求めない',
        'supply_have_up_salary' => '昇給有り',
        'supply_can_become_employee' => '正社員渡洋有り',
        'supply_have_carfare' => '交通費支給',
        'supply_have_free_meal' => 'まかないあり',
        'can_change_working_day' => 'シフト調整可能',
        'pay_per_day' => '日払い可能',
        'vietnamese_working' => 'ベトナム人勤務中',
        'nepal_working' => 'ネパール人勤務中',
        'no_need_skill' => '履歴書不要',
        'no_need_experience' => '未経験OK',
        'no_need_japanese_level' => '日本語レベル求めない',
        'have_up_salary' => '昇給有り',
        'can_become_employee' => '正社員渡洋有り',
        'have_carfare' => '交通費支給',
        'have_free_meal' => 'まかないあり',
        'home_nearest_station' => '最寄り駅（勤務先）',
        'workplace_stations' => '最寄り駅（勤務先）',

        // demand
        'watching'   => 'ウォッチリスト',
        'apply_by_phone'   => '応募（電話）',
        'apply_by_email'   => '応募（メール）',
        'acceptance'   => '内定',
        'cancel_employment'   => '不採用',
        'cancel_acceptance'   => '内定取消',
        'employment'   => '採用',
        'celebration'  => 'お祝い金の申請数',
        'school_nearest_station'  => '最寄り駅（日本語学校）',
        'demand' => [
            'title_index'   => 'KPI',
            'title_rate'   => '継続率',
            'title_sequence_trigger'   => 'シーケンス（トリガー）',
            'title_sequence'   => 'シーケンス（累積）',
            'title_jlpt'   => '日本語能力',
            'title_important'   => '仕事で大事なこと',
            'job_type'          => '職種・職務内容',
            'medium_job_type'   => '職種・職務内容の平均時給',
            'title_station'   => '最寄り駅（勤務先）',
        ],


    ],
    'celebration_money' => [
        'title_index'   => 'お祝い金管理',
    ],
    'user' => [
        'title_index'   => 'サプライユーザリスト',
        'password'   => 'サプライユーザのパスワード変更',
        'index'   => 'サプライユーザリスト',
        'edit'   => 'サプライユーザ情報編集',
    ],
];