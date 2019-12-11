<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AdTbl Entity
 *
 * @property int $adseq
 * @property string $title
 * @property string $contents
 * @property int $pub_flg
 * @property int $pos_flg
 * @property string $file_path
 * @property int $viewflg
 * @property int $timerflg
 * @property \Cake\I18n\Time $opendata
 * @property \Cake\I18n\Time $timerdata
 * @property \Cake\I18n\Time $up_date
 * @property \Cake\I18n\Time $regdate
 */
class AdTbl extends Entity
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
        'adseq' => false
    ];
}
