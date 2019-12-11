<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DtbProduct Entity
 *
 * @property int $product_id
 * @property string $name
 * @property string $name_vn
 * @property int $maker_id
 * @property int $status
 * @property string $comment1
 * @property string $comment2
 * @property string $comment3
 * @property string $comment4
 * @property string $comment5
 * @property string $comment6
 * @property string $note
 * @property string $main_list_comment
 * @property string $main_list_comment_vn
 * @property string $main_list_image
 * @property string $main_comment
 * @property string $main_comment_vn
 * @property string $main_image
 * @property string $main_large_image
 * @property int $del_flg
 * @property int $creator_id
 * @property \Cake\I18n\FrozenTime $create_date
 * @property \Cake\I18n\FrozenTime $update_date
 * @property int $deliv_date_id
 * @property int $dummy_flg
 * @property int $position
 * @property \Cake\I18n\FrozenDate $end_date
 * @property int $offer_number
 * @property int $client_id
 * @property string $client_introduction
 * @property string $client_introduction_vn
 * @property string $client_zip01
 * @property string $client_zip02
 * @property int $client_pref
 * @property string $client_addr01
 * @property int $target
 * @property string $category_id
 * @property int $employment_status
 * @property int $salary_type
 * @property int $currency
 * @property float $salary_min
 * @property float $salary_max
 * @property string $salary
 * @property string $salary_vn
 * @property string $exchange_rate
 * @property int $region
 * @property int $city
 * @property string $work_location
 * @property string $work_location_vn
 * @property string $traffic_access
 * @property string $traffic_access_vn
 * @property string $working_hour
 * @property string $working_hour_vn
 * @property string $working_day
 * @property string $working_day_vn
 * @property string $lunch_time
 * @property string $lunch_time_vn
 * @property string $trial_period
 * @property string $trial_period_vn
 * @property string $sex
 * @property string $qualification
 * @property string $qualification_vn
 * @property string $personality
 * @property string $personality_vn
 * @property string $skill
 * @property string $skill_vn
 * @property string $payrise
 * @property string $payrise_vn
 * @property string $bonus
 * @property string $bonus_vn
 * @property string $insurance
 * @property string $insurance_vn
 * @property string $welfare
 * @property string $other_welfare
 * @property string $other_welfare_vn
 * @property string $medical_checkup
 * @property string $medical_checkup_vn
 * @property string $applicate_method
 * @property string $applicate_method_vn
 * @property string $selection_process
 * @property int $concierge
 *
 * @property \App\Model\Entity\Maker $maker
 * @property \App\Model\Entity\Creator $creator
 * @property \App\Model\Entity\DelivDate $deliv_date
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\Category $category
 */
class DtbProduct extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'name_vn' => true,
        'maker_id' => true,
        'status' => true,
        'comment1' => true,
        'comment2' => true,
        'comment3' => true,
        'comment4' => true,
        'comment5' => true,
        'comment6' => true,
        'note' => true,
        'main_list_comment' => true,
        'main_list_comment_vn' => true,
        'main_list_image' => true,
        'main_comment' => true,
        'main_comment_vn' => true,
        'main_image' => true,
        'main_large_image' => true,
        'del_flg' => true,
        'creator_id' => true,
        'create_date' => true,
        'update_date' => true,
        'deliv_date_id' => true,
        'dummy_flg' => true,
        'position' => true,
        'end_date' => true,
        'offer_number' => true,
        'client_id' => true,
        'client_introduction' => true,
        'client_introduction_vn' => true,
        'client_zip01' => true,
        'client_zip02' => true,
        'client_pref' => true,
        'client_addr01' => true,
        'target' => true,
        'category_id' => true,
        'employment_status' => true,
        'salary_type' => true,
        'currency' => true,
        'salary_min' => true,
        'salary_max' => true,
        'salary' => true,
        'salary_vn' => true,
        'exchange_rate' => true,
        'region' => true,
        'city' => true,
        'work_location' => true,
        'work_location_vn' => true,
        'traffic_access' => true,
        'traffic_access_vn' => true,
        'working_hour' => true,
        'working_hour_vn' => true,
        'working_day' => true,
        'working_day_vn' => true,
        'lunch_time' => true,
        'lunch_time_vn' => true,
        'trial_period' => true,
        'trial_period_vn' => true,
        'sex' => true,
        'qualification' => true,
        'qualification_vn' => true,
        'personality' => true,
        'personality_vn' => true,
        'skill' => true,
        'skill_vn' => true,
        'payrise' => true,
        'payrise_vn' => true,
        'bonus' => true,
        'bonus_vn' => true,
        'insurance' => true,
        'insurance_vn' => true,
        'welfare' => true,
        'other_welfare' => true,
        'other_welfare_vn' => true,
        'medical_checkup' => true,
        'medical_checkup_vn' => true,
        'applicate_method' => true,
        'applicate_method_vn' => true,
        'selection_process' => true,
        'concierge' => true,
        'maker' => true,
        'creator' => true,
        'deliv_date' => true,
        'client' => true,
        'category' => true
    ];
}
