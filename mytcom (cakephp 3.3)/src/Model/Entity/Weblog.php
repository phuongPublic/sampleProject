<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Weblog Entity
 *
 * @property string $user_seq
 * @property \Cake\I18n\Time $log_date
 * @property int $weblog_wather
 * @property string $weblog_title
 * @property string $weblog_body
 * @property string $weblog_url1
 * @property string $weblog_url2
 * @property string $weblog_url3
 * @property \Cake\I18n\Time $up_date
 * @property \Cake\I18n\Time $reg_date
 * @property int $weblog_id
 *
 * @property \App\Model\Entity\Weblog $weblog
 */
class Weblog extends Entity
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
            'user_seq' => false,
            'log_date' => false,
            'weblog_id' => false
    ];
}
