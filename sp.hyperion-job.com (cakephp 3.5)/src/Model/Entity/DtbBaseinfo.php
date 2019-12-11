<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DtbBaseinfo Entity
 *
 * @property int $id
 * @property string $company_name
 * @property string $company_kana
 * @property string $zip01
 * @property string $zip02
 * @property string $zipcode
 * @property int $country_id
 * @property int $pref
 * @property string $addr01
 * @property string $addr02
 * @property string $tel01
 * @property string $tel02
 * @property string $tel03
 * @property string $fax01
 * @property string $fax02
 * @property string $fax03
 * @property string $business_hour
 * @property string $law_company
 * @property string $law_manager
 * @property string $law_zip01
 * @property string $law_zip02
 * @property string $law_zipcode
 * @property int $law_country_id
 * @property int $law_pref
 * @property string $law_addr01
 * @property string $law_addr02
 * @property string $law_tel01
 * @property string $law_tel02
 * @property string $law_tel03
 * @property string $law_fax01
 * @property string $law_fax02
 * @property string $law_fax03
 * @property string $law_email
 * @property string $law_url
 * @property string $law_term01
 * @property string $law_term02
 * @property string $law_term03
 * @property string $law_term04
 * @property string $law_term05
 * @property string $law_term06
 * @property string $law_term07
 * @property string $law_term08
 * @property string $law_term09
 * @property string $law_term10
 * @property string $email01
 * @property string $email02
 * @property string $email03
 * @property string $email04
 * @property float $free_rule
 * @property string $shop_name
 * @property string $shop_kana
 * @property string $shop_name_eng
 * @property float $point_rate
 * @property float $welcome_point
 * @property \Cake\I18n\FrozenTime $update_date
 * @property string $top_tpl
 * @property string $product_tpl
 * @property string $detail_tpl
 * @property string $mypage_tpl
 * @property string $good_traded
 * @property string $message
 * @property string $regular_holiday_ids
 * @property string $latitude
 * @property string $longitude
 * @property float $downloadable_days
 * @property int $downloadable_days_unlimited
 * @property float $exchange_rate
 *
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\LawCountry $law_country
 */
class DtbBaseinfo extends Entity
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
        'company_name' => true,
        'company_kana' => true,
        'zip01' => true,
        'zip02' => true,
        'zipcode' => true,
        'country_id' => true,
        'pref' => true,
        'addr01' => true,
        'addr02' => true,
        'tel01' => true,
        'tel02' => true,
        'tel03' => true,
        'fax01' => true,
        'fax02' => true,
        'fax03' => true,
        'business_hour' => true,
        'law_company' => true,
        'law_manager' => true,
        'law_zip01' => true,
        'law_zip02' => true,
        'law_zipcode' => true,
        'law_country_id' => true,
        'law_pref' => true,
        'law_addr01' => true,
        'law_addr02' => true,
        'law_tel01' => true,
        'law_tel02' => true,
        'law_tel03' => true,
        'law_fax01' => true,
        'law_fax02' => true,
        'law_fax03' => true,
        'law_email' => true,
        'law_url' => true,
        'law_term01' => true,
        'law_term02' => true,
        'law_term03' => true,
        'law_term04' => true,
        'law_term05' => true,
        'law_term06' => true,
        'law_term07' => true,
        'law_term08' => true,
        'law_term09' => true,
        'law_term10' => true,
        'email01' => true,
        'email02' => true,
        'email03' => true,
        'email04' => true,
        'free_rule' => true,
        'shop_name' => true,
        'shop_kana' => true,
        'shop_name_eng' => true,
        'point_rate' => true,
        'welcome_point' => true,
        'update_date' => true,
        'top_tpl' => true,
        'product_tpl' => true,
        'detail_tpl' => true,
        'mypage_tpl' => true,
        'good_traded' => true,
        'message' => true,
        'regular_holiday_ids' => true,
        'latitude' => true,
        'longitude' => true,
        'downloadable_days' => true,
        'downloadable_days_unlimited' => true,
        'exchange_rate' => true,
        'country' => true,
        'law_country' => true
    ];
}
