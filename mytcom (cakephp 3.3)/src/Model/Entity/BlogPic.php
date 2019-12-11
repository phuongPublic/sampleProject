<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BlogPic Entity
 *
 * @property int $blog_pic_id
 * @property string $user_seq
 * @property \Cake\I18n\Time $log_date
 * @property int $pic_id
 * @property int $album_id
 * @property \Cake\I18n\Time $up_date
 * @property \Cake\I18n\Time $reg_date
 * @property int $weblog_id
 *
 * @property \App\Model\Entity\BlogPic $blog_pic
 * @property \App\Model\Entity\Pic $pic
 * @property \App\Model\Entity\Album $album
 * @property \App\Model\Entity\Weblog $weblog
 */
class BlogPic extends Entity
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
            'blog_pic_id' => false,
            'user_seq' => false
    ];
}
