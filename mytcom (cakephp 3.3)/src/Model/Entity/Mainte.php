<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Mainte Entity
 *
 * @property int $mainte_id
 * @property string $mainte_body
 * @property string $mainte_status
 * @property \Cake\I18n\Time $mainte_start_time
 * @property string $mainte_end_flg
 * @property \Cake\I18n\Time $mainte_end_time
 * @property int $mainte_opt_flg
 * @property int $mainte_kso_flg
 *
 * @property \App\Model\Entity\Mainte $mainte
 */
class Mainte extends Entity
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
        'mainte_id' => false
    ];
}
