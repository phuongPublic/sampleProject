<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DtbOrderTemp Entity
 *
 * @property string $order_temp_id
 * @property int $customer_id
 * @property string $message
 * @property string $order_name01
 * @property string $order_name02
 * @property string $order_kana01
 * @property string $order_kana02
 * @property string $order_company_name
 * @property string $order_email
 * @property string $order_tel01
 * @property string $order_tel02
 * @property string $order_tel03
 * @property string $order_fax01
 * @property string $order_fax02
 * @property string $order_fax03
 * @property string $order_zip01
 * @property string $order_zip02
 * @property string $order_zipcode
 * @property int $order_country_id
 * @property int $order_pref
 * @property string $order_addr01
 * @property string $order_addr02
 * @property int $order_sex
 * @property \Cake\I18n\FrozenTime $order_birth
 * @property int $order_job
 * @property float $subtotal
 * @property float $discount
 * @property int $deliv_id
 * @property float $deliv_fee
 * @property float $charge
 * @property float $use_point
 * @property float $add_point
 * @property float $birth_point
 * @property float $tax
 * @property float $total
 * @property float $payment_total
 * @property int $payment_id
 * @property string $payment_method
 * @property string $note
 * @property int $mail_flag
 * @property int $status
 * @property int $cv_type
 * @property string $cv_file
 * @property int $deliv_check
 * @property int $point_check
 * @property \Cake\I18n\FrozenTime $create_date
 * @property \Cake\I18n\FrozenTime $update_date
 * @property int $device_type_id
 * @property int $del_flg
 * @property int $order_id
 * @property string $memo01
 * @property string $memo02
 * @property string $memo03
 * @property string $memo04
 * @property string $memo05
 * @property string $memo06
 * @property string $memo07
 * @property string $memo08
 * @property string $memo09
 * @property string $memo10
 * @property string $session
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\OrderCountry $order_country
 * @property \App\Model\Entity\Deliv $deliv
 * @property \App\Model\Entity\Payment $payment
 * @property \App\Model\Entity\DeviceType $device_type
 * @property \App\Model\Entity\Order $order
 */
class DtbOrderTemp extends Entity
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
        'customer_id' => true,
        'message' => true,
        'order_name01' => true,
        'order_name02' => true,
        'order_kana01' => true,
        'order_kana02' => true,
        'order_company_name' => true,
        'order_email' => true,
        'order_tel01' => true,
        'order_tel02' => true,
        'order_tel03' => true,
        'order_fax01' => true,
        'order_fax02' => true,
        'order_fax03' => true,
        'order_zip01' => true,
        'order_zip02' => true,
        'order_zipcode' => true,
        'order_country_id' => true,
        'order_pref' => true,
        'order_addr01' => true,
        'order_addr02' => true,
        'order_sex' => true,
        'order_birth' => true,
        'order_job' => true,
        'subtotal' => true,
        'discount' => true,
        'deliv_id' => true,
        'deliv_fee' => true,
        'charge' => true,
        'use_point' => true,
        'add_point' => true,
        'birth_point' => true,
        'tax' => true,
        'total' => true,
        'payment_total' => true,
        'payment_id' => true,
        'payment_method' => true,
        'note' => true,
        'mail_flag' => true,
        'status' => true,
        'cv_type' => true,
        'cv_file' => true,
        'deliv_check' => true,
        'point_check' => true,
        'create_date' => true,
        'update_date' => true,
        'device_type_id' => true,
        'del_flg' => true,
        'order_id' => true,
        'memo01' => true,
        'memo02' => true,
        'memo03' => true,
        'memo04' => true,
        'memo05' => true,
        'memo06' => true,
        'memo07' => true,
        'memo08' => true,
        'memo09' => true,
        'memo10' => true,
        'session' => true,
        'customer' => true,
        'order_country' => true,
        'deliv' => true,
        'payment' => true,
        'device_type' => true,
        'order' => true
    ];
}
