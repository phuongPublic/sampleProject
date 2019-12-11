<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PicTbl Entity
 *
 * @property int $pic_id
 * @property int $album_id
 * @property string $user_seq
 * @property string $pic_name
 * @property string $name
 * @property string $extension
 * @property int $amount
 * @property string $base
 * @property string $pic_url
 * @property string $pic_comment
 * @property \Cake\I18n\Time $up_date
 * @property \Cake\I18n\Time $reg_date
 *
 * @property \App\Model\Entity\Pic $pic
 * @property \App\Model\Entity\Album $album
 */
class PicTbl extends Entity
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
        'pic_id' => false,
        'user_seq' => false
    ];
}
