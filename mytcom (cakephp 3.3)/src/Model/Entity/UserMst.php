<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserMst Entity
 *
 * @property string $user_seq
 * @property string $user_address
 * @property string $user_name
 * @property string $reg_flg
 * @property string $del_flg
 * @property \Cake\I18n\Time $up_date
 * @property \Cake\I18n\Time $reg_date
 * @property string $user_id
 * @property string $user_password
 * @property string $base
 * @property string $mobile_id
 * @property string $mail_seq
 * @property int $file_size
 * @property int $album_size
 * @property string $reminder_pc
 * @property string $reminder_mobile
 * @property bool $reminder_mobile_flg
 * @property bool $reminder_pc_flg
 * @property int $reminder_time
 * @property int $movie_size
 * @property \Cake\I18n\Time $log_date
 * @property string $google_token
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Mobile $mobile
 */
class UserMst extends Entity
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
        '*' => true,
        'user_seq' => false
    ];
}
