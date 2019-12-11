<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DtbCustomer Entity
 *
 * @property int $customer_id
 * @property string $name01
 * @property string $name02
 * @property string $kana01
 * @property string $kana02
 * @property string $company_name
 * @property string $zip01
 * @property string $zip02
 * @property string $zipcode
 * @property int $country_id
 * @property int $pref
 * @property string $addr01
 * @property string $addr02
 * @property string $email
 * @property string $email_mobile
 * @property string $tel01
 * @property string $tel02
 * @property string $tel03
 * @property string $fax01
 * @property string $fax02
 * @property string $fax03
 * @property int $sex
 * @property int $job
 * @property \Cake\I18n\FrozenTime $birth
 * @property string $password
 * @property int $reminder
 * @property string $reminder_answer
 * @property string $salt
 * @property string $secret_key
 * @property \Cake\I18n\FrozenTime $first_buy_date
 * @property \Cake\I18n\FrozenTime $last_buy_date
 * @property float $buy_times
 * @property float $buy_total
 * @property float $point
 * @property string $note
 * @property int $status
 * @property \Cake\I18n\FrozenTime $create_date
 * @property \Cake\I18n\FrozenTime $update_date
 * @property int $del_flg
 * @property string $mobile_phone_id
 * @property int $mailmaga_flg
 * @property string $tel
 * @property int $receive_work_info
 * @property string $image
 * @property string $cv
 * @property string $resume
 * @property string $cv_name
 * @property string $cv_update
 * @property string $resume_name
 * @property int $marital_status
 * @property int $current_address
 * @property string $pref_by_text
 * @property int $education
 * @property string $school_name
 * @property string $major
 * @property string $desired_work
 * @property string $desired_position
 * @property float $current_salary
 * @property float $desired_salary
 * @property string $desired_region
 * @property int $work_experience
 * @property int $jp_level
 * @property string $jp_other
 * @property string $toeic
 * @property string $ielts
 * @property string $eng_other
 * @property string $other_language
 * @property string $qualification
 * @property string $skill
 * @property string $self_pr
 *
 * @property \App\Model\Entity\Country $country
 */
class DtbCustomer extends Entity
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
        'name01' => true,
        'name02' => true,
        'kana01' => true,
        'kana02' => true,
        'company_name' => true,
        'zip01' => true,
        'zip02' => true,
        'zipcode' => true,
        'country_id' => true,
        'pref' => true,
        'addr01' => true,
        'addr02' => true,
        'email' => true,
        'email_mobile' => true,
        'tel01' => true,
        'tel02' => true,
        'tel03' => true,
        'fax01' => true,
        'fax02' => true,
        'fax03' => true,
        'sex' => true,
        'job' => true,
        'birth' => true,
        'password' => true,
        'reminder' => true,
        'reminder_answer' => true,
        'salt' => true,
        'secret_key' => true,
        'first_buy_date' => true,
        'last_buy_date' => true,
        'buy_times' => true,
        'buy_total' => true,
        'point' => true,
        'note' => true,
        'status' => true,
        'create_date' => true,
        'update_date' => true,
        'del_flg' => true,
        'mobile_phone_id' => true,
        'mailmaga_flg' => true,
        'tel' => true,
        'receive_work_info' => true,
        'image' => true,
        'cv' => true,
        'resume' => true,
        'cv_name' => true,
        'cv_update' => true,
        'resume_name' => true,
        'marital_status' => true,
        'current_address' => true,
        'pref_by_text' => true,
        'education' => true,
        'school_name' => true,
        'major' => true,
        'desired_work' => true,
        'desired_position' => true,
        'current_salary' => true,
        'desired_salary' => true,
        'desired_region' => true,
        'work_experience' => true,
        'jp_level' => true,
        'jp_other' => true,
        'toeic' => true,
        'ielts' => true,
        'eng_other' => true,
        'other_language' => true,
        'qualification' => true,
        'skill' => true,
        'self_pr' => true,
        'country' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
