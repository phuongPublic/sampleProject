<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TopicsTbl Entity
 *
 * @property int $topicsseq
 * @property int $categoryid
 * @property string $title
 * @property string $contents
 * @property string $file_path1
 * @property string $file_path2
 * @property int $viewflg
 * @property int $dateviewflg
 * @property int $windowflg
 * @property int $timerflg
 * @property \Cake\I18n\Time $opendata
 * @property \Cake\I18n\Time $timerdata
 * @property string $updateuser
 * @property \Cake\I18n\Time $up_date
 * @property string $reguser
 * @property \Cake\I18n\Time $regdate
 */
class TopicsTbl extends Entity
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
        'topicsseq' => false
    ];

}
