<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GroupTbl Entity
 *
 * @property int $group_id
 * @property string $user_seq
 * @property string $group_name
 * @property \Cake\I18n\Time $up_date
 * @property \Cake\I18n\Time $reg_date
 *
 * @property \App\Model\Entity\Group $group
 */
class GroupTbl extends Entity
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
        'group_id' => false,
        'user_seq' => false
    ];
}
