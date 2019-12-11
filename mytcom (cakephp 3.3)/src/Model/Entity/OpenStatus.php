<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OpenStatus Entity
 *
 * @property string $open_id
 * @property int $target_id
 * @property string $user_seq
 * @property int $open_type
 * @property \Cake\I18n\Time $close_date
 * @property int $close_type
 * @property int $access_check
 * @property string $nickname
 * @property string $message
 * @property \Cake\I18n\Time $reg_date
 * @property int $download_count
 *
 * @property \App\Model\Entity\Open $open
 * @property \App\Model\Entity\Target $target
 */
class OpenStatus extends Entity
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
        'open_id' => false,
        'target_id' => false,
        'user_seq' => false,
        'open_type' => false
    ];
}
