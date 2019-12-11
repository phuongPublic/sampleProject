<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Album Entity
 *
 * @property int $album_id
 * @property string $user_seq
 * @property string $album_name
 * @property string $album_comment
 * @property int $album_pic_count
 * @property \Cake\I18n\Time $up_date
 * @property \Cake\I18n\Time $reg_date
 *
 * @property \App\Model\Entity\Album $album
 */
class Album extends Entity
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
        'album_id' => false,
        'user_seq' => false
    ];
}
