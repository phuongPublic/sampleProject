<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TargetUser Entity
 *
 * @property int $target_user_seq
 * @property string $user_seq
 * @property string $open_id
 * @property int $open_type
 * @property string $mail
 * @property \Cake\I18n\Time $login_date
 * @property \Cake\I18n\Time $reg_date
 *
 * @property \App\Model\Entity\Open $open
 */
class TargetUser extends Entity
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
        'target_user_seq' => false,
        'user_seq' => false,
        'open_id' => false
    ];
}
